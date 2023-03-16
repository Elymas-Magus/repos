double media (double *lista, int n)
{
    return sigma (lista, 0, n) / n;
}

double sigma (double *lista, int ini, int fim)
{
    unsigned int i;
    double sum = 0;
    for (i = ini; i < fim; i++)
    {
        sum += lista[i];
    }

    return sum;
}

double variancia (double *v, double media,  int n)
{
    unsigned int i;
    double sum = 0;
    for (i = 0; i < n; i++)
    {
        sum += pow((v[i] - media), 2);
    }

    return sqrt(sum/(n - 1));
}