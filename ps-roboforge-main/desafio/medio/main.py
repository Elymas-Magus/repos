import math
import operator
import functools
import ProgressaoAritmetica as PA

def is_primo (num):
    num = int(num)
    
    if num % 2 == 0 and num != 2:
        return False
    
    for i in range(3, math.floor(math.sqrt(num)) + 1, 2):
        if num % i == 0:
            return False
    
    return True

def main():
    lista = PA.gera_lista(1, 2)
    lista_primos = filter(is_primo, lista)
    produto_primos = functools.reduce(operator.mul, lista_primos)
    
    print(produto_primos)

main()