#!/usr/bin/env python
from sympy.logic.boolalg import to_cnf
from sympy.logic import simplify_logic
def toCnf(s):

    try:
        z=simplify_logic(s)
        x=to_cnf(z)
        return str(x)
    except:
        return 'this is wrong format'
'''
directions for use:
dictionary
 or : Or
 and :And
 +
 not:Not
 xor:Xor
 implies :Implies(a,b)
dictionary
 or : |
 and : &
 xor:^
 not : ~
 implies : >>
'''

myfile = "C:\\Users\hp\Downloads\College-Website-main\College-Website-main\lat\Images\cs.txt"

with open(myfile, "r+") as f:
    content = f.read()
    cmds = content.split('<OR>')
    for i in range(len(cmds)):
        cmds[i] = toCnf(cmds[i]) + '\n'
    f.seek(0)
    f.writelines(cmds)
    f.truncate()
