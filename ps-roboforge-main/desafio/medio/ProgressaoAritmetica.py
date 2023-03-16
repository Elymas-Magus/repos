def last_term(first_term, nmemb, ratio):
    return first_term + (nmemb - 1) * ratio

def gera_lista(first_elemnt, razao):
    return list(range(first_elemnt, last_term(first_elemnt, 10, razao) + 1, razao))