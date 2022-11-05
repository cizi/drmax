# Načtení první stovky záznamů z webu https://news.ycombinator.com/ dle zadání

- php 7.4 projekt
- prvotní myšlenka byla taková najít RSS FEED, ze kterého bych to parsoval, což se povedlo jen na 50%, protože https://news.ycombinator.com/rss zobrazují jen prvních cca 30 záznamů a nepodařilo se mi to parametry URL upravit tak, jak bych to potřeboval, čímž by se celá situace zjednodušila (nemusel bych parsovat HTML)
- poté jsem šel cestou tohoto https://hnrss.github.io/, kde šlo URL parametrizovat pro počet záznamů atp. ale zase žádná z verzí nebyla 1:1 se zadáním, nejblíže se tomu blížila tahle https://hnrss.org/frontpage, ale i tak to nebylo ono
- parsování HTML je dělané pomocí DOM dokumentu a XPATH hledání, není to ideální, ale snad pro příklad bude dostačující, nechtěl jsem používat externí knihovny 
- narazil jsem tam na jeden problém a to ten, že struktura stránky nebyla konstatní (viz obrázek), kde vypadlo pár elemetů a tudíž parsování pomocí XPATH selhávalo, tyto položky přeskakuji (což je samozřejmě špatně, ale ......)
