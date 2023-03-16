#include "String.h"

char *
str_replace (char str[], const char original[], const char newstr[])
{
    char * buffer;
    if (
        original == NULL ||
        newstr == NULL ||
        str == NULL
    ) { return; }

    int bufferLen, strLen, originalLen, newstrLen;

    bufferLen = strlen(str) - strlen(original) + strlen(newstr) + 1;
    strLen = strlen(str);
    originalLen = strlen(original);
    newstrLen = strlen(newstr);

    char * pch, * pch2;

    buffer = (char *) malloc(bufferLen);
    buffer[0] = 0;

    pch = strstr (str, original);
    pch2 = str + strLen - strlen(pch) + originalLen;

    strncat (buffer, str, strLen - strlen(pch));
    strncat (buffer, newstr, strlen(newstr));
    strncat (buffer, pch2, strlen(pch2));

    return buffer;
}

char *
ucwords (char str[])
{
    char aux[strlen(str) + 1];
    unsigned int i;

    strcpy(aux, str);
    aux[0] = toupper(str[0]);

    return aux;
}

char *
capitalize (char str[])
{
    char aux[strlen(str) + 1];
    unsigned int i;
    for (i = 1; str[i]; i++) {
        aux[i] = tolower(str[i]);
    }

    aux[0] = toupper(str[0]);
    aux[i] = 0;

    return aux;
}

char *
strtoupper (char str[])
{
    char aux[strlen(str) + 1];
    unsigned int i;
    for (i = 0; str[i]; i++) {
        aux[i] = toupper(str[i]);
    }

    aux[i] = 0;

    return aux;
}

char *
strtolower (char str[])
{
    char aux[strlen(str) + 1];
    unsigned int i;
    for (i = 0; str[i]; i++) {
        aux[i] = tolower(str[i]);
    }

    aux[i] = '\0';

    return aux;
}
