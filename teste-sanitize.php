<pre><?php

$var = 'as"<b></b>df';
echo "antes: $var\n";

$out = htmlspecialchars($var, ENT_QUOTES | ENT_HTML401 | ENT_IGNORE);
echo "depois: $out\n";
?>
</pre>