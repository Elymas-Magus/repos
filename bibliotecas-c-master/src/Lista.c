#include "../include/Lista.h"


void quickSort(ArrayList l, int inicio, int fim, int (*compar)(const void *, const void *));
int quickSortParticionador(ArrayList l, int inicio, int fim, int (*compar)(const void *, const void *));

ArrayList
array_init()
{
    ArrayList l = (ArrayList) malloc(sizeof(List));

    l->first = l->last = NULL;
    l->length = 0;

    return l;
}

void
array_push(ArrayList l, void ** o)
{
    Node * no;
    no = (Node *) malloc (sizeof(Node));

    no->content = o;
    no->prev = NULL;
    no->next = NULL;

    if (l->first == NULL) {
        l->first = l->last = no;
    } else {
        no->prev = l->last;
        l->last->next = no;
        l->last = no;
    }

    l->length++;
}


void
array_shift(ArrayList l)
{
    if (l->first != NULL) {
        l->first = l->first->next;

        if (l->first != NULL){
            l->first->prev = NULL;

            if (l->first->next == NULL) {
                l->last = l->first;
            }
        } else {
            l->last = l->first;
        }

        l->length--;
    }
}


void
array_pop(ArrayList l)
{
    if (l->last != NULL) {
        if (l->last->prev == NULL) {
            l->first = l->last = NULL;
        } else {
            l->last = l->last->prev;
            l->last->next = NULL;
        }

        l->length--;
    }
}


void
array_set(ArrayList l, int n, void ** o)
{
    int i;
    Node * no;

    if (l->length <= n || n < 0) {
        return NULL;
    }

    no = l->first;
    for (i = 0; i < n; i++) {
        no = no->next;
    }

    if (no != NULL) {
        no->content = o;
    }
}


void **
array_item(ArrayList l, int n)
{
    int i;
    Node * no;

    if (l->length <= n || n < 0) {
        return NULL;
    }

    no = l->first;
    for (i = 0; i < n; i++) {
        no = no->next;
    }

    return no == NULL ?
        NULL : no->content;
}


void **
array_find(ArrayList l, void ** o, int (*compar)(const void ** a, const void ** b))
{
    Node * no;

    if (o == NULL || compar == NULL) {
        return NULL;
    }

    for (no = l->first; no; no = no->next) {
        if (compar(no->content, o) == 0) {
            return no;
        }
    }

    return NULL;
}


int
array_index(ArrayList l, void ** o, int (*compar)(const void ** a, const void ** b))
{
    int i = 0;
    Node * no;

    if (o == NULL || compar == NULL) {
        return -1;
    }

    for (no = l->first; no; no = no->next) {
        if (compar(no->content, o) == 0) {
            return i;
        }
        i++;
    }

    return NULL;
}


Node *
array_node(ArrayList l, void ** o, int (*compar)(const void ** a, const void ** b))
{
    Node * no;

    if (o == NULL || compar == NULL) {
        return NULL;
    }

    for (no = l->first; no; no = no->next) {
        if (compar(no->content, o) == 0) {
            return no;
        }
    }

    return NULL;
}


Node *
array_node_by_index(ArrayList l, int n)
{
    int i = 0;
    Node * no;

    if (n < 0 || n >= l->length) {
        return NULL;
    }

    for (no = l->first; no; no = no->next) {
        if (i == n) {
            return no;
        }
        i++;
    }

    return NULL;
}

void
array_exchange(ArrayList l, int posA, int posB)
{
    void ** auxiliar;
    Node * noA = array_node_by_index(l, posA);
    Node * noB = array_node_by_index(l, posB);

    if (noA != NULL && noB != NULL) {
        auxiliar = noA->content;
        noA->content = noB->content;
        noB->content = auxiliar;
    }

}


int
array_remove(ArrayList l, int n)
{
    int i;
    Node * no;

    if (l->length <= n || n < 0) {
        return FALSE;
    }

    no = l->first;
    for (i = 0; i < n; i++) {
        no = no->next;
    }

    no->next->prev = no->prev;
    no->prev->next = no->next;

    return TRUE;
}

void
array_sort(ArrayList l, int (*compar)(const void *, const void *))
{
    quickSort(l, 0, l->length - 1, compar);
}

void
quickSort(ArrayList l, int inicio, int fim, int (*compar)(const void *, const void *))
{
    int pivo;

    if (fim <= l->length && fim > inicio) {
        pivo = quickSortParticionador(l, inicio, fim, compar);
        quickSort(l, inicio, pivo - 1, compar);
        quickSort(l, pivo + 1, fim, compar);
    }
}

int
quickSortParticionador(ArrayList l, int inicio, int fim, int (*compar)(const void *, const void *))
{
    int esq, dir;
    void ** pivo, ** aux;

    esq = inicio;
    dir = fim;

    pivo = array_item(l, inicio);
    while (esq < dir) {
        while((aux = array_item(l, esq)) != NULL && compar(aux, pivo) <= 0) {
            esq++;
        }
        while((aux = array_item(l, dir)) != NULL && compar(aux, pivo) > 0) {
            dir--;
        }
        if (esq < dir) {
            array_exchange(l, esq, dir);
        }
    }
    array_set(l, inicio, array_item(l, dir));
    array_set(l, dir, pivo);

    return dir;
}

ArrayList
array_map(ArrayList l, void ** (* callback)(const void **, const int, const ArrayList l))
{
    int i = 0;
    Node * no;
    ArrayList newList = array_init();

    for (no = l->first; no; no = no->next) {
        array_push(newList, callback(no->content, i++, l));
    }

    return newList;
}
