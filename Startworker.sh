#!/bin/bash

val="$(grep -oE '\$worker = .*;' config.php | tail -1 | sed 's/$worker = //g;s/;//g')"

for ((i = 0;i < "$val";i++))
do
php TriviaConsumer.php &
done
echo All Consumers Started
