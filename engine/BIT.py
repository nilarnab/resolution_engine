from sympy.logic.boolalg import to_cnf
from sympy.logic import simplify_logic
def toCnf(s):

    try:
        z=simplify_logic(s)
        x=to_cnf(z)
        return x
    except:
        return 'this is wrong format'
'''
directions for use:

dictionary

 or : Or
 and :And
 not:Not
 xor:Xor
dictionary
 or : |
 and : &
 xor:^
 not : ~
'''
import re

myfile = "C:\\Users\hp\Downloads\College-Website-main\College-Website-main\lat\Images\cs.txt"

with open(myfile, "r+") as f:
    content = f.read()
    cmds = content.split('\n')
    for i in range(len(cmds)):
        cmds[i] = toCnf(cmds[i])
    f.seek(0)
    f.writelines(cmds)
    f.truncate()


