<?php
$a = array(
    'group1' => array('names'=>array('g1name1', 'g1name2')),
    'group2' => array('names'=>array('g2name1'))
);

$b = array(
    'group1' => array('names'=>array('g1name1', 'g1name3'), 'extras'=>array('g1extra1')),
    'group3' => array('names'=>array('g3name1'))
);

echo "<pre>";

$arr = array_merge_recursive($a, $b);
//print_r($arr);
array_walk($arr, function(&$data, $key) {
    print_r($data);
    foreach ($data as &$arr) {
        $arr = array_values(array_unique($arr));
    }
});
echo "<br>-----------------------<br>";

print_r($arr);
