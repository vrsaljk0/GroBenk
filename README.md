# GroBenk

Društvene mreža imaginarne banke krvi _GroBenk_ koja spaja bolnice kao krajnje korisnike krvi i donore na jednom mjestu.


### Motivation

Web aplikacija dizajnirana i implementirana u sklopu kolegija Razvoj web aplikacija i Baza podataka.


## Prerequisites

1. Web Server (WAMPP ili XAMPP)
2. Importati grobenk.sql u bazu na phpmyadminu pod nazivom grobenk


## Getting Started

1. u fileu dbconnect upisati svoje podatke.
2. pokrenuti index.html


## About

Aplikacija je podijeljena u četiri pristupne razine definirane slijedećim funkcionalnostima:

1. *Donor*
- Korisnik se može registrirati kao donor krvi.
- Na mom profilu pišu moji podaci i broj donacija (i nagrade ako ih imam)
- Povijest mojih donacija
- Mogu kliknuti da dolazim na evente koje objavi admin (nekakva kvazi geolokacija; riječkim donatorima se prikazuju samo eventi u Ri)
- Followanje/unfollowanje ostalih donora
- Mogu komentirati bolnice na njihovim profilima 
- Mogu poslati poruku drugim donorima (sustav kratkih poruka; nije chat u pravom smislu riječi jer nije "real time", za prikaz nove poruke potrebno je refreshati stranicu)
- Primam obavijesti (prvenstveno od admina)

2. *Admin*
- Admin prati donore i njihove donacije pa sukladno njima dodjeljuje
nagrade npr. za 50 donacija korisnik na svom profilu dobije srebrenu
zvjezdicu.
- Izrađuje "evente" za nove donacije 
Šalje obavijesti korisnicima npr. ako manjka A+ krvne grupe poslat će svim
takvim donorima obavijest ili ako se krv donira na Turniću svim donorima
koji su u blizini šalje se obavijest.
- Izrađuje mjesečne statistike koje se vide na naslovnoj stranici
- Unosi nove donacije 

Kako sustav doniranja funkcionira ? 
Nakon što admin objavi event donori se prijave na isti (klikom sa svog profila)
Admin dobije popis donora koji su se prijavili i označi ih klikom ako su stvarno donirali taj dan i koliko(broj donacija za donor++,
količina krvi++ itd).

Admin pregledava i zahtjeve od bolnica (klikom je odobri, zahtjev se izbriše, kolicina krvi--)


3. *Bolnice*
- Bolnice šalju zahtjeve za krvlju banci krvi
- Prate zalihe krvi i mogu objavljivati na naslovnoj stranici
- Sudjeluju na svom forumu (svaka bolnica ima svoj forum)

4. *Guest*

- Guest korisnik vidi "ono što je na površini"
- osnovne informacije (O nama, Kako donirati krvi, Gdje nas pronaći,
Kontakti itd)
- trenutne zalihe krvi

## Built With

* PHP5
* HTML5
* CSS
* JS
* SQL


## Authors

* **Maja Vrsaljko** - *Razvoj backend-a* - (https://github.com/vrsaljk0)

* **Azra Subašić** - *Razvoj frontend-a* - (https://github.com/hax91)

* **Ivana Baćac** - *Razvoj backend-a* - (https://github.com/Bachvac)

## Acknowledgments

* Projekt je ocjenjen maksimalnim brojem bodova na oba kolegija.

