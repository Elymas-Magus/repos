#ifndef STRING_H_INCLUDED
#define STRING_H_INCLUDED
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

char * str_replace (char str[], const char original[], const char newstr[]);
char * ucwords (char str[]);
char * capitalize (char str[]);
char * strtoupper (char str[]);
char * strtolower (char str[]);

#endif // STRING_H_INCLUDED
