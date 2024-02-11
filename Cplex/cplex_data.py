import sqlite3 as sql
from docplex.mp.model import Model
# script.py
import sys

# Récupérer les paramètres passés en ligne de commande
param1 = sys.argv[1] if len(sys.argv) > 1 else None
param2 = sys.argv[2] if len(sys.argv) > 2 else None

# Faire quelque chose avec les paramètres
result = "Résultat pour {} et {}".format(param1, param2)

# Afficher le résultat (sera récupéré par PHP)
print(result)


con = sql.connect("./../database.sqlite")

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
        request = "SELECT ? FROM ? WHERE ? = ?" + end_of_request
        execute_request = cur.execute(request, (columns, table[0], param[0], param[1],))
    
    else:
        return "error"
    
    result = execute_request.fetchall()
    
    return result


def getDispo(user):
    tab_dispo = [0 for i in range(24*7)]
    for i in range(7):
        dispo_jour = getFromDB(["users"], ["jour = " + i + " AND id_user", user], "h_deb, h_fin")



event_data = getFromDB(["evenements"], ["id_asso", param1], "id_event, id_lieu, nb_personnes, id_horaire, duree_mission, indice_prio_mission", "id_event")


users = getFromDB(["membres_assos"], ["id_asso", param1], "id_user", "id_user")

for user in users:
    competences = getFromDB(["join_competence"], ["id_join", user[0] + " AND num_type = 0"], "id_competence", "id_competence")
    user.append(competences)

#récupérer les infos des horaires et du lieu du membre.

#récupérer l'ancienneté etc...



## Création du modèle
model = Model(name='example')


nbMiss = len(event_data)
nbBene = len(users)
nbAsso = 1
nbComp = 7

#Variable p pour la priorité
p = []
for i in range(len(event_data)):
    p.append(int(event_data[i][5]))
 
#Variable com pour les compétences des benevoles 
com = []
for user in users:
    lst_comp = [0 for i in range(nbComp-1)]
    for competence in user[1]:
        lst_comp[int(competence)] = 1
    lst_comp.append(1)
    com.append(lst_comp)


for user in users:
    dispo_user = 

dispo_bene = [[0 for j in range(len(users[0][1]))] for i in range(len(users))]

# D = [[0,1,0,1],[1,1,0,1],[0,1,1,1],[1,1,1,1]]
    
# Variables de poids mises par défaut
r1 = 5 #Nombre de missions remplies
r2 = 2 #priorité
r3 = 3 #distance
r4 = 1 #ancienneté


# C = [[1 for i in range(7)] for i in range(4)]
# Di = [10 for i in range(4)]
# L = [[1 for i in range(4)] for i in range(4)]
# T = [[1 for i in range(4)] for i in range(4)]

# m[jtems][ktems] -> historique des missions


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

