#ifndef STRING_H_INCLUDED
#define STRING_H_INCLUDED

void limpa_buffer ()
{
    char c;
    while ((c = fgetc(stdin)) != EOF && c != '\n');
}

#endif // STRING_H_INCLUDED



