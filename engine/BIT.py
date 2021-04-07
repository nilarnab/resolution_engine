#!C:/Users/nilar/AppData/Local/Programs/Python/Python38-32/python.exe


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

myfile = "../text_files/test.txt"

with open(myfile, "r+") as f:
    content = f.read()
    cmds = content.split()
    for i in range(len(cmds)):
        cmds[i] = toCnf(cmds[i]) + '\n'

    for i in range(len(cmds)):
        cmds[i] = ((cmds[i].replace('~', '<NEG>')).replace('|', '<OR>')).replace('&', '<AND>')

    f.seek(0)
    f.writelines(cmds)
    f.truncate()

