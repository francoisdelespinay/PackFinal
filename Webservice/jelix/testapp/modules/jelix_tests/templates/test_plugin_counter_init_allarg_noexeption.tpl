{counter_init '2', '0', 2, -2}{counter_init '3', '00', 3, 3}{counter_init '4', 'aa', 'g', -1}{counter_init NULL, 'AA', 'E', 5}{for $i=0;$i<5;$i++}{counter '2'}{if $i!=4}-{/if}{/for},{for $i=0;$i<5;$i++}{counter '3'}{if $i!=4}-{/if}{/for},{for $i=0;$i<5;$i++}{counter '4'}{if $i!=4}-{/if}{/for},{for $i=0;$i<5;$i++}{counter}{if $i!=4}-{/if}{/for}