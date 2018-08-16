
variable1="$(grep -oE '\$variable1 = .*;' config.php | tail -1 | sed 's/$woker = //g;s/;//g'