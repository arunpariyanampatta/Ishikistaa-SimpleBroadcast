
variable1="$(grep -oE '\$worker = .*;' config.php | tail -1 | sed 's/$woker = //g;s/;//g'