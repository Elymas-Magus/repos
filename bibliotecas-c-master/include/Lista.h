#ifndef LISTA_H_INCLUDED
#define LISTA_H_INCLUDED
#include <stdio.h>
#include <stdlib.h>
#include "ListDef.h"
#define TRUE 1
#define FALSE 0

ArrayList array_init();

void array_push(ArrayList l, void ** o);

void array_shift(ArrayList l);

void array_pop(ArrayList l);

void array_set(ArrayList l, int n, void ** o);

void array_exchange(ArrayList l, int posA, int posB);

void ** array_item(ArrayList l, int n);

void ** array_find(ArrayList l, void ** o, int (* compar)(const void ** a, const void ** b));

void array_sort(ArrayList l, int (*compar)(const void *, const void *));

int array_index(ArrayList l, void ** o, int (* compar)(const void ** a, const void ** b));

int array_remove(ArrayList l, int n);

Node * array_node_by_index(ArrayList l, int n);

Node * array_node(ArrayList l, void ** o, int (* compar)(const void ** a, const void ** b));

ArrayList array_map(ArrayList l, void ** (* callback)(const void **, const int, const ArrayList l));

#endif // LISTA_H_INCLUDED
