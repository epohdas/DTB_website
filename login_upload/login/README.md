treba spraviť css-ko!!!
index je ako keby už hlavná stránka kam sa dostaneš po prihlásení ale to je tam iba pre test 
ide to spustiť iba v php storme. 
je tam chyba pri: $link ale to je chyba php stormu ide to aj tak.

a tak isto treba vytvoriť db s menom: registered

a pacnúť tam toto:

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;


a taktiež budete musieť zmeniť path k php

win -> upraviť premenné prostredia pre konto používateľa
path -> upraviť
nové
pacnete tam toto : C:\xampp\php

OK 
zavrieť

a nezabudnite reštartovať phpstrom

prajem príjemnú zábavu a pevné nervy:) 
