# Ticket registravimo sistema

Tai Laravel pagrindu sukurta ticket (bilietų) registravimo ir sekimo sistema.

Sukurtas kaip egzamino projektas.


# Vartotojai ir rolės
Sistemoje naudojamos trys vartotojų rolės:
    *user* – paprastas vartotojas
    *support* – palaikymo specialistas
    *admin* – administratorius

Rolės apibrėžia vartotojo teises sistemoje.


# Ticket valdymas
    Vartotojai gali kurti ticket's
    Vartotojas mato ir redaguoja tik savo ticket's
    Support ir administratorius mato visus ticket's
    Ticket priskiriami kategorijoms, kurios saugomos duomenų bazėje

Ticket būsenos:
    new – Naujas
    in_progress – Vykdomas
    done – Užbaigtas


# Prieigos kontrolė
    Prieiga prie ticket priklauso nuo vartotojo rolės ir savininko
    Support keičia ticket būseną ir rašo komentarus
    Administratorius turi pilną prieigą


# Komentarai
    Support ir administratorius gali rašyti komentarus prie ticket
    Vartotojas gali peržiūrėti komentarus


# El. pašto pranešimai
Vartotojas gauna el. pašto pranešimą, kai:
    prie jo ticket pridedamas komentaras
    pasikeičia ticket būsena

El. pašto pranešimai veikia naudojant Laravel Notifications.  
Testavimui naudojamas el. pašto siuntimas į log failą. (storage/logs/laravel.log)


# Ataskaitos
    Administratorius ir support gali sugeneruoti aktyvių ticket's ataskaitą PDF formatu


# Testiniai vartotojai

|  Rolė   |       El. paštas       | Slaptažodis |
|---------|------------------------|-------------|
|  admin  |     admin@test.com     |  Admin123!  |
| support |    supportas@test.com  |  supportas  |
|   user  |  martynas@studentas.lt |   martynas  |


# Autorius
Martynas Petrauskas  
PS24
Šiauliai, 2026 
