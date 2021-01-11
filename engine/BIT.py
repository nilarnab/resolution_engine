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
