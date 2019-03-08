<?php

$resultado = [
    '7',
    '10',
    '21',
    '22',
];


print_r(array_search('18', $resultado) === false);
print_r(array_search('7',  $resultado));
print_r(array_search('10', $resultado));
print_r(array_search('21', $resultado));
print_r(array_search('22', $resultado));
print_r(array_search('23', $resultado));
?>;