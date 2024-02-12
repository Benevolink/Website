import sqlite3 as sql
from docplex.mp.model import Model
# script.py
import sys

# # Récupérer les paramètres passés en ligne de commande
# param1 = sys.argv[1] if len(sys.argv) > 1 else None
# param2 = sys.argv[2] if len(sys.argv) > 2 else None

# # Faire quelque chose avec les paramètres
# result = "Résultat pour {} et {}".format(param1, param2)

# # Afficher le résultat (sera récupéré par PHP)
# print(result)
param1 = 6


con = sql.connect("./database.sqlite")

cur = con.cursor()


#Fonction de base pour aller chercher des éléments dans la BDD
#table -> liste des tables (si len(table)>1 alors il faut join les tables avec les arguments dans join)
#param sont les paramèetres de where, par défaut 1 = 1 toujours vrai
#columns les colonnes à choisir dans la bdd
#order_by si besoin d'ordonner les data
#join lié à table
def getFromDB(table, param = ["1", "1"], columns = '*', order_by = None, join = None):
    end_of_request = ""
    if order_by != None:
        end_of_request = " ORDER BY " + order_by
    
    if len(table) == 2 and len(join) == 2:
        request = "SELECT ? FROM ? JOIN ? ON ? = ? WHERE ? = ?" + end_of_request
        execute_request = cur.execute(request, (columns, table[0], table[1], join[0], join[1], param[0], param[1],))

    elif len(table) == 1:
        request = f"SELECT {columns} FROM {table[0]} WHERE {param[0]} = {param[1]}{end_of_request}"
        execute_request = cur.execute(request)
    
    else:
        return "error"
    
    result = execute_request.fetchall()
    
    return result


event_data = getFromDB(["evenements"], ["id_asso", param1], "id_event, id_lieu, nb_personnes, id_horaire, duree_mission, indice_prio_mission", "id_event")

users = getFromDB(["membres_assos"], ["id_asso", param1], "id_user", "id_user")

for i in range(len(users)):
    user = users[i]
    competences = getFromDB(["join_competence"], ["id_join", f"{user[0]} AND num_type = 0"], "id_competence", "id_competence")
    user += (competences,)
    users[i] = user


#récupérer les infos des horaires et du lieu du membre.

#récupérer l'ancienneté etc...



## Création du modèle
model = Model(name='example')


nbMiss = len(event_data)
nbBene = len(users)
nbAsso = 1
nbComp = 7

#Variable p pour la priorité
def getPriority(event_data):
    p = []
    for i in range(len(event_data)):
        p.append(event_data[i][5])
    return p

p = getPriority(event_data)

def getDispo(id_user):
    tab_dispo = [0 for i in range(24*7)]

    for i in range(7):

        dispo_jour = getFromDB(["disponibilites"], [f"jour = {i} AND id_user", id_user], "h_deb, h_fin")

        if len(dispo_jour) == 0:
            break
        h_deb_hour = int(dispo_jour[0][0].strftime("%H"))
        h_fin_hour = int(dispo_jour[0][1].strftime("%H"))

        for j in range(int(h_deb_hour + i*24), int(h_fin_hour + i*24)):
            tab_dispo[j] = 1
    return tab_dispo

def getHour(id_horaire):
    tab_hours = [0 for i in range(24*7)]
    print(id_horaire)
    
    dispo_jour = getFromDB(["horaire"], ["id_horaire", id_horaire], "date_debut, date_fin, heure_debut, heure_fin")
    print(dispo_jour)
    j_deb = int(dispo_jour[0][0].strftime("%w"))
    j_fin = int(dispo_jour[0][1].strftime("%w"))
    h_deb = int(dispo_jour[0][2].strftime("%H"))
    h_fin = int(dispo_jour[0][3].strftime("%H"))

    for i in range(24*j_deb + h_deb, 24*j_fin + h_fin):
        tab_hours[i] = 1
    return tab_hours

def getD(events, users):
    dispo_users = []
    creneaux_events = []

    for user in users:
        dispo_users.append(getDispo(user[0]))
    
    for event in events:
        print(events)
        creneaux_events.append(getHour(event[3]))
    
    D = [[0 for j in range(len(users))] for i in range(len(events))]

    for i in range(len(events)):
        for j in range(len(users)):
            correspondance = 1
            for k in range(24*7):
                if creneaux_events[j][k] == 1 and dispo_users[i][k] == 0:
                    correspondance = 0
                    k=24*7
            D[i][j] = correspondance
    return D

D = getD(event_data, users)
    
# Variables de poids mises par défaut
r1 = 5      #Nombre de missions remplies
r2 = 2      #priorité
r3 = 3      #distance
r4 = 1      #ancienneté


# Récupérer les compétences utilisateurs ou asso
def getComp_all(id_user_asso, type, nbComp):
    lst_comp = [0 for i in range(nbComp)]
    db_id_comp = getFromDB(["join_competence"], [f"num_type = {type} AND id_join", id_user_asso], "id_competence, nb_necessaire")
    for competence in db_id_comp:
        if type:
            lst_comp[competence[0]] = competence[1]
        else:
            lst_comp[competence[0]] = 1
    return lst_comp

#Variable com pour les compétences des benevoles 
def getC(event_data, nbComp):
    C = []
    for event in event_data:
        C.append(getComp_all(event[0], 1, nbComp))
    return C

C = getC(event_data, nbComp)

# Variables pour les nombres de bénévoles par compétence 
def getCom(users, nbComp):
    com = []
    for user in users:
        com.append(getComp_all(user[0], 0, nbComp))
    return com

com = getCom(user, nbComp)

#Distance acceptee par le benevole
def getDistMax(users):
    Di = []
    for user in users:
        dispo_user = getFromDB(["users"], ["id", user[0]], "dist_max_accepte")
        Di.append(dispo_user[0][0])
    return Di

Di = getDistMax(users)


# L = [[1 for i in range(4)] for i in range(4)]
def getT(event_data, users):
    T = [[0] for j in range(len(users)) for i in range(len(event_data))]
    max_time_lst = [0 for i in range(len(users))]
    event_time_lst = [0 for i in range(len(event_data))]

    for i in range(len(users)):
        id_user = users[i][0]
        duree_max = getFromDB(["users"], ["id", id_user], "duree_max_accepte")
        max_time_lst[i] = duree_max[0][0]
    
    for j in range(len(event_data)):
        event_time_lst[j] = getHour(event_data[j][3]).sum()


# T = [[1 for i in range(4)] for i in range(4)]


def getHistorique(users):
    nbBene = len(users)
    m = [[0] for j in range(nbBene)]
    for j in range(nbBene):
        user = users[j]
        anciennete = getFromDB(["membres_assos"], ["id_user", user[0]], "anciennete")
        m[j][0] = anciennete[0][0]
    return m

m = getHistorique(users)


items = range(0, nbMiss )
jtems = range(0, nbBene )
ktems = range(0, nbAsso )
ltems = range(0, nbComp )
""""
p = [model.integer_var(name='p_{0}'.format(i)) for i in items]
m = [[model.integer_var(name='m_{0}_{1}'.format(j, k)) for k in ktems] for j in jtems]
D = [[model.integer_var(name='D_{0}_{1}'.format(i, j), vtype='B') for j in jtems] for i in items]
com = [[model.integer_var(name='com_{0}_{1}'.format(j, l), vtype='B') for l in ltems] for j in jtems]
C = [[model.integer_var(name='C_{0}_{1}'.format(i, l)) for l in ltems] for i in items]
Di = [model.integer_var(name='Di_{0}'.format(i)) for i in items]
L = [[model.integer_var(name='L_{0}_{1}'.format(i, j)) for j in jtems] for i in items]
T = [[model.integer_var(name='T_{0}_{1}'.format(i, j)) for j in jtems] for i in items]
"""
X = [[model.binary_var(name='X_{0}_{1}'.format(i,j)) for j in jtems] for i in items]
Y = [model.binary_var(name='Y_{0}'.format(i)) for i in items]
o = [[model.integer_var(name='o_{0}_{1}'.format(i,j)) for j in jtems] for i in items]
u = [[model.integer_var(name='u_{0}_{1}'.format(i,j)) for j in jtems] for i in items]

# Objectif

# Contraintes
for j in jtems:
    model.add_constraint(model.sum([X[i][j] for i in items]) <= 1)

for j in jtems:
    for i in items:
        model.add_constraint(X[i][j] <= D[i][j])

for i in items:
    for l in ltems:
        if C[i][l] > 0:
            model.add_constraint(model.sum(com[j][l] * X[i][j] for j in jtems) <= C[i][l] * Y[i])
"""
for j in jtems:
    for i in items:
        model.add_constraint(Di[j] * X[i][j] + o[i][j] - u[i][j] == L[i][j])
"""
for j in jtems:
    for i in items:
        model.add_constraint(X[i][j] <= T[i][j])

for i in items:
    for j in jtems:
        for q in jtems:
            if q != j:
                model.add_constraint(X[i][j] + X[i][q] <= 1)

model.maximize(r1 * model.sum(Y[i] for i in items) +
               r2 * model.sum(p[i] * Y[i] / 5 for i in items) -
               r3 * model.sum(o[i][j] / L[i][j] + u[i][j] / L[i][j] for i in items for j in jtems) +
               r4 * model.sum(X[i][j] * m[j][k] / 100 for i in items for j in jtems for k in ktems))



# Résolution du modèle
solution = model.solve()
if solution is not None:
    print(solution.export_as_sol(path="./",basename="test.sol"))
else:
    print('Le modèle n\'a pas été résolu avec succès.')



con.close()

