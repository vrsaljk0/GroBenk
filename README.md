# GroBenk-Vol2
Novi repozitorij BloodBank GroBenk projekta iz RWA.
Kako sve funkcionira ukratko (da imamo lijepi pregled svega što moramo napraviti).

INSTALACIJA
------------
Kako bi mogli pokrenuti našu banku krvi potrebno je imati instalirano:
1. Server (WAMPP ili XAMPP)
2. importati grobenk.sql u bazu na phpmyadminu pod nazivom grobenk
2. u fileu dbconnect upisati svoje podatke.
3. pokrenuti index.html

EDITOR
-------
Ja sam si instalirali PHPStorm iz JetBoxa i postavila WAMPP kao Interpreter i onda mogu pokretati kodove direktno iz editora.
Tamo sam si još namjestila live uređivanje stranice da ne moram svaki put refreshati i još neke detaljčiće za ugodniji rad.

PLAN I PROGRAM (kopirani iz mejla Sandiju)
---------------

1. Donor
- Korisnik se može registrirati kao donor krvi. (done)
- Na mom profilu pišu moji podaci i broj donacija (i nagrade ako ih imam)
- Povijest mojih donacija
- Mogu kliknuti da dolazim na evente koje objavi admin
- Followanje/unfollowanje ostalih donora
- Mogu komentirati bolnice na njihovim profilima
- Mogu poslati poruku drugim donorima
- Primam obavijesti

2. Admin
- Admin prati donore i njihove donacije pa sukladno njima dodjeljuje
nagrade npr. za 50 donacija korisnik na svom profilu dobije srebrenu
zvjezdicu.
- Izrađuje "evente" za nove donacije (koji se odmah označe na karti) -
Šalje obavijesti korisnicima npr. ako manjka A+ krvne grupe poslat će svim
takvim donorima obavijest ili ako se krv donira na Turniću svim donorima
koji su u blizini šalje se obavijest.
- Sudjeluje u "live chatu" za sve koji posjete stranicu (i za gueste i za
donore)
- Na pitanje u "live chatu" može odgovarati i donor koji je ostvario preko
100 donacija.
- Izrađuje mjesečne statistike koje se vide na naslovnoj stranici

Kako sustav doniranja funkcionira ? 
Nakon što admin objavi event donori se prijave na isti (klikom sa svog profila)
Admin dobije popis donora koji su se prijavili i označi ih klikom ako su stvarno donirali taj dan i koliko(broj donacija za donor++,
količina krvi++ itd).

Admin pregledava i zahtjeve od bolnica (klikom je odobri, zahtjev se izbriše, kolicina krvi--)


3. Bolnice
- Bolnice šalju zahtjeve za krvlju banci krvi
- Prate zalihe krvi i mogu objavljivati na naslovnoj stranici

4. Guest

-Guest korisnik vidi "ono što je na površini"
- osnovne informacije (O nama, Kako donirati krvi, Gdje nas pronaći,
Kontakti itd)
- trenutne zalihe krvi
- može poslati upit na "live chat"
-blabla

SO MUCH WORK :( :(

