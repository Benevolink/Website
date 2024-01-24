import sqlite3 as sql
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

event_main = cur.execute("SELECT id_event, id_lieu, nb_personnes, id_horaire FROM evenements WHERE id_asso = " + param1) #!! penser à mettre la priorité aussi pour la var p

event_horaire = cur.execute("SELECT * FROM horaire where id_horaire = " + event_main.fetchall[3])

users_in_asso = cur.execute("SELECT id_user FROM membres_assos WHERE id_asso = " + param1 + "AND statut = 1")

#récupérer les infos des horaires et du lieu du membre.

#récupérer l'ancienneté etc...



## Création du modèle
model = Model(name='example')


# nbMiss = 4
# nbBene = 4
# nbAsso = 4
# nbComp = 7
# p = [4,3,2,1]
# m = [[0,50,25,10],[0,50,25,10],[0,50,25,10],[0,50,25,10]]
# D = [[0,1,0,1],[1,1,0,1],[0,1,1,1],[1,1,1,1]]
# r1 = 1
# r2 = 1
# r3 = 1
# r4 = 1
# com = [[1 for i in range(7)] for i in range(4)]
# C = [[1 for i in range(7)] for i in range(4)]
# Di = [10 for i in range(4)]
# L = [[1 for i in range(4)] for i in range(4)]
# T = [[1 for i in range(4)] for i in range(4)]


# items = range(0, nbMiss )
# jtems = range(0, nbBene )
# ktems = range(0, nbAsso )
# ltems = range(0, nbComp )
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

