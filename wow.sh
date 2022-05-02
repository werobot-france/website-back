curl 'http://localhost:8000/post/6117c70e466f3' -X PUT -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:90.0) Gecko/20100101 Firefox/90.0' -H 'Accept: application/json, text/plain, */*' -H 'Accept-Language: en' --compressed -H 'Content-Type: application/json;charset=utf-8' -H 'Authorization: Bearer root' -H 'Origin: http://localhost:3002' -H 'DNT: 1' -H 'Connection: keep-alive' -H 'Referer: http://localhost:3002/' -H 'Sec-Fetch-Dest: empty' -H 'Sec-Fetch-Mode: cors' -H 'Sec-Fetch-Site: cross-site' --data-raw $'{"id":"6117c70e466f3","title":"Retour sur la saison 2020/2021","content":"Le r\xe9cap\' de la saison 2020/2021 qui, malgr\xe9 le virus, a \xe9t\xe9 tr\xe8s riche.\\n\\n# Les concours de robotique\\n\\nVous avez bien lu : il y en a eu plusieurs \041\\n\\n## La coupe de France de Robotique\\n\\nComme annonc\xe9 dans <a href=\\"https://werobot.fr/blog/coupe-de-france-de-robotique\\">notre article</a> du 21 octobre 2020, MAtthieu et Mohamed ont particip\xe9 \xe0 cette coupe. Si nous en avons le courage, nous publierons un article d\xe9taill\xe9e sur celle-ci. En attendant, vous pouvez revivre nos matchs ci-dessous :\\n\\n<table>\\n<tr>\\n<th text-align=\\"right\\">Premi\xe8re s\xe9rie</th>\\n</tr>\\n<tr>\\n<td><iframe width=\\"560\\" height=\\"315\\" src=\\"https://www.youtube.com/embed/Uda1RO031lA\\" frameborder=\\"0\\" allow=\\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\\" allowfullscreen></iframe></td>\\n</tr>\\n<tr>\\n<th>Deuxi\xe8me s\xe9rie</th>\\n</tr>\\n</tr>\\n<td>Malheureusement celle-ci n\'a pas \xe9t\xe9 film\xe9e</td>\\n</tr>\\n<tr>\\n<th>Troisi\xe8me s\xe9rie</th>\\n</tr>\\n<tr>\\n<td><iframe width=\\"560\\" height=\\"315\\" src=\\"https://www.youtube.com/embed/7x27fJUfQTw \\" frameborder=\\"0\\" allow=\\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\\" allowfullscreen></iframe></td>\\n</tr>\\n</table>\\n\\net admirer nos deux comp\xe9titeurs sur place :\\n\\n<div class=\\"mosaic two-columns\\">\\n  <img src=\\"https://static.werobot.fr/blog/bob-ross/6116b0c518e0f/50.jpg\\">\\n  <img src=\\"https://static.werobot.fr/blog/bob-ross/6116b0d1c6cf9/50.jpg\\">\\n</div>\\n\\n## Les troph\xe9es de robotique\\n\\nComme les ann\xe9es pr\xe9c\xe9dentes, nous avons commenc\xe9 l\'ann\xe9e avec ce concours incontournable. Nous avons accueilli deux nouveaux membres : Haroun (qui est un fr\xe8re de Mohamed) et Mat\xe9o qui ont rejoins Mathis, le v\xe9t\xe9ran de l\'ann\xe9e \041\\nEn d\xe9but de saison, ils ont commenc\xe9 \xe0 prendre en main le mat\xe9riel :\\n\\n<table>\\n<tr> \\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/61169a6207bde/50.jpg\\"></td>\\n<td rowspan=\\"2\\"><img src=\\"https://static.werobot.fr/blog/bob-ross/61169a5a02d6a/50.jpg\\"></td>\\n</tr>\\n<tr> \\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/61169a40883cd/50.jpg\\"></td>\\n</tr>\\n</table>\\n\\n\\nMalheureusement le confinement de novembre nous a d\xe9cid\xe9 \xe0 ne pas nous investir dans ce concours cette ann\xe9e de peur qu\'il ne soit annul\xe9 comme l\'ann\xe9e pr\xe9c\xe9dente.\\n\\n## Student Robotics\\n\\nNous nous sommes alors tourn\xe9 vers un concours anglais qui, depuis l\'ann\xe9e derni\xe8re, s\'est un peu \\"reconstruit\\" pour avoir lieu en ligne.\\nL\'objectif est de programmer un robot virtuel qui va devoir \xe9voluer sur un plateau de jeu num\xe9rique.\\n\\nCette ann\xe9e, le robot \xe9volue sur une table de jeu sur laquelle sont dispos\xe9s des pilliers qu\'il doit \\"capturer\\" en s\'en approchant suffisament pendant un certain temps. Le vainqueur est le robot poss\xe9dant le plus de pilliers \xe0 la fin du temps imparti.\\nLa comp\xe9tition s\'est d\xe9roul\xe9e sur plusieurs mois, en plusieurs phases, entre lesquelles la table de jeu et les r\xe8gles ont l\xe9g\xe8rement chang\xe9s. L\'\xe9quipe devait donc am\xe9liorer sont robot entre chaque tour pour l\'adapter aux nouvelles r\xe8gles.\\nVoici les images des diff\xe9rentes tables de jeu :\\n\\n\\n<div class=\\"image-mosaic\\">\\n  <img src=\\"https://static.werobot.fr/blog/bob-ross/611790fd3f7fa/50.png\\">\\n  <img src=\\"https://static.werobot.fr/blog/bob-ross/611790fe08050/50.png\\">\\n  <img src=\\"https://static.werobot.fr/blog/bob-ross/611790fedf2ab/50.png\\">\\n</div>\\n\\nOn y note bien l\'\xe9volution de la complexit\xe9. Non seulement le terrain n\'est plus le m\xeame mais on voit appara\xeetre des liens entre les pilliers puis des contours color\xe9s autour de certains d\'entre eux. Pour plus de d\xe9tails vous pouvez lire <a href=\\"https://studentrobotics.org/docs/resources/2021/rulebook.html\\">les r\xe8gles du jeu</a> (en anglais).\\n\\nCi-dessous un aper\xe7u de notre derni\xe8re victoire, on peut constater que notre robot est \\"intelligent\\" : Son chemin est pr\xe9vu d\'avance mais si il se rend compte que ses adversaire lui ont fait perdre des pilliers, il est capable d\'aller les r\xe9cup\xe9rer.\\nC\'est un travail vraiment impressionnant r\xe9alis\xe9 par les jeunes et cela m\xe9ritait une victoire.\\n\\nNotre robot est le rose dans ce match :\\n\\n<iframe width=\\"560\\" height=\\"315\\" src=\\"https://www.youtube.com/embed/1Ckhpb7Pexc \\" frameborder=\\"0\\" allow=\\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\\" allowfullscreen></iframe>\\n\\nMalheureusement, de petites erreurs de programmation dans le chemin programm\xe9 l\'ont amen\xe9 \xe0 se coincer dans un angle au matche suivant (quart de finale) que nous avons perdu.\\n\\nCette fois-ci, notre robot est le jaune (le programme est inchang\xe9, le robot s\'adapte automatiquement \xe0 son c\xf4t\xe9 de la table)\\n\\n<iframe width=\\"560\\" height=\\"315\\" src=\\"https://www.youtube.com/embed/WgGeoibX8AE\\" frameborder=\\"0\\" allow=\\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\\" allowfullscreen></iframe>\\n\\nCependant la performance de l\'\xe9quipe pour sa premi\xe8re participation \xe0 cette comp\xe9tition a \xe9t\xe9 telle que nous avons re\xe7u le \\"Prix des d\xe9butants\\" \xe7a ne rend pas tr\xe8s bien comme appellation mais en anglais \xe7a donne : \\"Rookie Award\\".\\n\\n<div class=\\"image-mosaic\\">\\n  <img src=\\"https://static.werobot.fr/blog/bob-ross/6117b4b106d04/50.png\\">\\n  <img src=\\"https://static.werobot.fr/blog/bob-ross/61169c4657347/50.jpg\\">\\n</div>\\n\\nLe d\xe9tail des r\xe9sultats, tour par tour, ainsi que les liens vers les vid\xe9os de tous les matchs sont disponibles sur le site de <a href=\\"https://studentrobotics.org/\\">Student Robotics</a>\\n\\n## International Roboticist Challenge\\n\\nNous avons encha\xeen\xe9 sur un concours international organis\xe9 par la Malaisie (plus pr\xe9cis\xe9ment la soci\xe9t\xe9 Roboticist : <a href=\\"http://roboticist.com.my/\\">site web</a> et <a href=\\"https://www.facebook.com/myroboticist\\">page facebook </a> pour plus d\'informations). Ce concours \xe9tait de moins longue haleine.\\n\\n\xc0 peine sortis de Student Robotics, on nous a propos\xe9 de nous inscrire :\\n\\n<img src=\\"https://static.werobot.fr/blog/bob-ross/6117b783336c9/50.jpg\\" text-align=\\"center\\">\\n\\nCette comp\xe9tition est divis\xe9e en plusieurs \xe9preuves diff\xe9rentes et ind\xe9pendantes. Nous avons constitu\xe9 deux \xe9quipes :\\n- Une avec seulement Mat\xe9o pour l\'\xe9preuve \\"Virtual Robot Programming\\" ;\\n- L\'autre avec Haroun et Mathis pour l\'\xe9preuve \\"Mobile Robot CAD Design\\"\\n\\nLe concours  a rencontr\xe9 un certain succ\xe8s et a r\xe9unis un grand nombre de pays diff\xe9rents :\\n\\n<img src=\\"https://static.werobot.fr/blog/bob-ross/6117b77ebc84f/50.jpg\\">\\n\\n### Virtual Robot Programming\\n\\nCette \xe9preuve avait deux \xe9tapes :\\n- Tout d\'abord Mat\xe9o devait programmer un robot virtuel dans un environnement \xe0 blocs de fa\xe7on \xe0 lui faire r\xe9aliser des actions pr\xe9d\xe9finies le plus rapidement possible. <img src=\\"https://static.werobot.fr/blog/bob-ross/6117b7811e4e6/50.png\\">\\n- Suite \xe0 ce programme, Mat\xe9o a \xe9t\xe9 qualifi\xe9 (arrivant dans les 10 premiers sur 120 participants). Il a alors d\xfb se confronter \xe0 deux d\xe9fis de programmation et r\xe9pondre \xe0 des questions le tout en direct, en visio et en anglais \041\\nSes succ\xe8s se sont arr\xe9t\xe9 l\xe0 mais quel parcours \041\\n\\n### Mobile Robot CAD Design\\n\\nL\'autre \xe9preuve \xe9tait \xe9galement en deux \xe9tapes.\\n\\n- Haroun et Mathis on d\xfb concevoir un robot en 3D en utilisant le logiciel impos\xe9 <a href=\\"https://www.vexrobotics.com/iq/downloads/cad-snapcad\\">snapCAD</a> qu\'ils ne connaissaient pas du tout. Ils pouvaient laisser libre-cours \xe0 leur imagination mais le robot devait \xeatre fonctionnel, devait utiliser au moins une poulie et une courroie et devait avoir une utilit\xe9 potentielle.\\n\\n<div class=\\"image-mosaic\\">\\n  <img src=\\"https://static.werobot.fr/blog/bob-ross/6117bb8ad9513/50.png\\">\\n  <img src=\\"https://static.werobot.fr/blog/bob-ross/6117bb89061d7/50.jpg\\">\\n</div>\\n\\n- Une fois leur travail rendu, ils ont \xe9t\xe9 soumis au m\xeame traitement que Mat\xe9o : une pr\xe9sentation de leur travail \xe0 faire en direct, en visio et en anglais.\\n\\nLeur travail et leur investissement ont \xe9t\xe9 r\xe9compens\xe9s :\\n\\n<img src=\\"https://static.werobot.fr/blog/bob-ross/6117b77d79c86/50.jpg\\">\\n\\n### Arbitrage\\n\\nPetit clin d\'oeil final, Franck a \xe9galement particip\xe9 \xe0 cette comp\xe9tition en tant qu\'arbitre de l\'\xe9preuve \\"STEM-Robotics Pitch\\" qui consistait, pour les participants, \xe0 pr\xe9senter le concept d\'un robot pouvant servir dans le cadre de th\xe8mes qui leur \xe9taient impos\xe9s.\\n\\n<img src=\\"https://static.werobot.fr/blog/bob-ross/6117b77f9238a/50.jpg\\">\\n\\n\\n# L\'Atelier Num\xe9rique\\n\\nLa grande nouveaut\xe9 de l\'ann\xe9e \xe9tait la mise en place de l\'atelier num\xe9rique du samedi matin \xe0 destination des 10-15 ans.\\n\\nNuos avons eu quatre jeunes inscrits qui y ont particip\xe9 toute l\'ann\xe9e avec un engouement fantastique : Salom\xe9, Quentin, Swann et Timoth\xe9.\\n\\n<div class=\\"image-mosaic\\">\\n  <img src=\\"https://static.werobot.fr/blog/bob-ross/61169a712524c/50.jpg\\">\\n  <img src=\\"https://static.werobot.fr/blog/bob-ross/61169a691b530/50.jpg\\">\\n</div>\\n\\nLe confinement ne nous a pas emp\xeach\xe9 de poursuivre tout au long de l\'ann\xe9e : la plupart des ateliers ont eu lieu en distanciel \041 Les jeunes ont \xe9t\xe9 tr\xe8s assidus et \xe9tonnament autonomes.\\n\\nNous avons pu travailler sur :\\n- <a href=\\"https://code.org\\">Code.org</a> (lessons sur la programmation par blocs)\\n- <a href=\\"https://scratch.mit.edu/\\">Scratch</a> (r\xe9alisation d\'histoires anim\xe9es et interactives, de jeux)\\n- <a href=\\"http://ai2.appinventor.mit.edu/\\">AppInventor</a> (cr\xe9ation d\'application sur smatphone)\\n- <a href=\\"https://makecode.microbit.org/\\">MakeCode</a> (programmation des <a href=\\"https://microbit.org/fr/\\">Micro:Bit</a>)\\n\\nDe plus nous avons particip\xe9 \xe0 deux concours de programmations en ligne : <a href=\\"https://castor-informatique.fr/\\">Castor Informatique</a> et <a href=\\"https://algorea.org/\\">Algor\xe9a</a>\\n\\n<table>\\n<tr>\\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/6117c025241f6/50.jpg\\"></td>\\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/6117c0236d5b2/50.jpg\\"></td>\\n</tr>\\n<tr>\\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/6117c0a21eca7/50.jpg\\"></td>\\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/6117c0a2cf122/50.jpg\\"></td>\\n</tr>\\n</table>\\n\\nLe tout s\'est d\xe9roul\xe9 dans une bonne humeur et un entrain fantastique. Je pense que tout le monde en redemande \041\\n\\n# Atelier de robotique de la maison de quartier\\nEntre deux confinements, l\'association a poursuivi sa collaboration avec l\'<a href=\\"https://www.espacecondorcet.org/\\">Espace Condorcet</a> et men\xe9 l\'atelier robotique.\\n\\nLes cinq filles qui y ont particip\xe9 cette ann\xe9e \xe9taient tr\xe8s motiv\xe9es.\\nApr\xe8s avoir assembl\xe9 les robots :\\n\\n<table>\\n<tr>\\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/61169aa8df034/50.jpg\\"></td>\\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/61169ab08a582/50.jpg\\"></td>\\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/61169aa2cbf48/50.jpg\\"></td>\\n</tr>\\n</table>\\n\\n nous avons pu les faire rouler, tourner et clignoter tr\xe8s rapidement en passant par la case programmation :\\n\\n <table>\\n<tr>\\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/61169b491ac1f/50.jpg\\"></td>\\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/61169b429e1a1/50.jpg\\"></td>\\n</tr>\\n</table>\\n\\nPuis nous nous sommes lanc\xe9 dans le pari fou d\'\xeatre capable de faire suivre \xe0 notre robot des parcours pr\xe9-\xe9tablis :\\n\\n<table>\\n<tr>\\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/61169b06cae24/50.jpg\\"></td>\\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/61169b0cef451/50.jpg\\"></td>\\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/61169b93e06e7/50.jpg\\"></td>\\n</tr>\\n<tr>\\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/61169b8dc6a9e/50.jpg\\"></td>\\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/61169b875250d/50.jpg\\"></td>\\n<td><img src=\\"https://static.werobot.fr/blog/bob-ross/61169b814f559/50.jpg\\"></td>\\n</table>\\n\\nDe plus en plus compliqu\xe9s \041\041\\n\\nBilan : beaucoup d\'amusement, un peu de frustration parfois et de grandes satisfactions.\\n\\nBon \xe9t\xe9 \041","slug":"retour-sur-la-saison-20202021","image":"https://static.werobot.fr/blog/bob-ross/61169c5184a4e/50.jpg","locale":"fr","identifier":"6117c70e46855","description":"Le r\xe9cap\' de la saison 2020/2021 qui, malgr\xe9 le virus, a \xe9t\xe9 tr\xe8s riche.","user_id":null,"created_at":"2021-08-14 13:37:18","updated_at":"2021-08-14 17:06:54"}'