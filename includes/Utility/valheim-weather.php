<?php
// PHP port of kirilloid RNG and weather/wind generator (minimal, deterministic)
// Functions: getWeathersAt($idx) and getGlobalWind($idx)

namespace Jotunheim\Utility;

class Yj {
    public $state;
    public function __construct($t=0){ $this->init($t); }
    public static function u32($x){ return $x & 0xFFFFFFFF; }
    public static function imul32($a,$b){
        $prod = (int)($a) * (int)($b);
        return $prod & 0xFFFFFFFF;
    }
    public function init($e){
        $t = self::u32($e);
        $r = self::imul32($t,1812433253) + 1; $r &= 0xFFFFFFFF;
        $i = self::imul32($r,1812433253) + 1; $i &= 0xFFFFFFFF;
        $a = self::imul32($i,1812433253) + 1; $a &= 0xFFFFFFFF;
        $this->state = ['a'=>$t,'b'=>$r,'c'=>$i,'d'=>$a];
        return $this->state;
    }
    public function next(){
        $a = $this->state['a'];
        $e = ($a ^ (($a << 11) & 0xFFFFFFFF)) & 0xFFFFFFFF;
        $this->state['a'] = $this->state['b'];
        $this->state['b'] = $this->state['c'];
        $this->state['c'] = $this->state['d'];
        $d = $this->state['d'];
        $d = ($d ^ (($d >>> 19) ?? ($d >> 19)) ^ $e ^ (($e >>> 8) ?? ($e >> 8))) & 0xFFFFFFFF;
        // PHP doesn't have >>>; emulate unsigned right shift by mask
        $d = $this->state['d'];
        // compute new d according to JS logic
        $a = $this->state['a']; // after shifts above
        // Reimplement next using 32-bit arithmetic closely
        $a0 = $this->state['a'];
        $b0 = $this->state['b'];
        $c0 = $this->state['c'];
        $d0 = $this->state['d'];
        $e0 = ($a0 ^ (($a0 << 11) & 0xFFFFFFFF)) & 0xFFFFFFFF;
        $newA = $b0;
        $newB = $c0;
        $newC = $d0;
        $tmp = ($d0 ^ (($d0 >> 19) & 0xFFFFFFFF) ^ $e0 ^ (($e0 >> 8) & 0xFFFFFFFF)) & 0xFFFFFFFF;
        $newD = $tmp;
        $this->state = ['a'=>$newA,'b'=>$newB,'c'=>$newC,'d'=>$newD];
        return $newD;
    }
    public function random(){
        $n = $this->next();
        // (this.next() << 9 >>> 0) / 4294966784
        $v = (($n << 9) & 0xFFFFFFFF);
        // unsigned divide
        return ($v & 0xFFFFFFFF) / 4294966784.0;
    }
    public function rangeFloat($a,$b){ return $b - $this->random() * ($b - $a); }
}

// constants
$g = (object)['q'=>125,'p'=>666,'h'=>1800,'j'=>'Clear','i'=>3600];
$rg = ["Meadows","BlackForest","Swamp","Mountain","DeepNorth","Plains","Ashlands","Mistlands","Ocean"];
$om = [
    'Meadows'=>[['Clear',25],['Rain',1],['Misty',1],['ThunderStorm',1],['LightRain',1]],
    'BlackForest'=>[['DeepForest_Mist',20],['Rain',1],['Misty',1],['ThunderStorm',1]],
    'Swamp'=>[['SwampRain',1]],
    'Mountain'=>[['SnowStorm',1],['Snow',5]],
    'DeepNorth'=>[['Twilight_SnowStorm',1],['Twilight_Snow',2],['Twilight_Clear',1]],
    'Plains'=>[['Heath_clear',5],['Misty',1],['LightRain',1]],
    'Ashlands'=>[['Ashlands_ashrain',30],['Ashlands_misty',2],['Ashlands_CinderRain',4],['Ashlands_storm',1]],
    'Mistlands'=>[['Mistlands_clear',15],['Mistlands_rain',1],['Mistlands_thunder',1]],
    'Ocean'=>[['Rain',1],['LightRain',1],['Misty',1],['Clear',10],['ThunderStorm',1]]
];

function og($weatherSeed, $ig){
    global $g, $rg, $om;
    if (!$weatherSeed || $weatherSeed < $g->i / $g->p) {
        $out = [];
        foreach ($rg as $r) $out[] = $g->j;
        return $out;
    }
    $ig->init($weatherSeed);
    $t = $ig->rangeFloat(0,1);
    $res = [];
    foreach ($rg as $b) {
        $list = $om[$b];
        $totalWeight = 0;
        foreach ($list as $x) $totalWeight += $x[1];
        $total = $totalWeight * $t;
        $acc = 0;
        $picked = end($list)[0];
        foreach ($list as $entry) {
            $acc += $entry[1];
            if ($total < $acc) { $picked = $entry[0]; break; }
        }
        $res[] = $picked;
    }
    return $res;
}

function ag($e,$t,&$r,$ig){
    global $g;
    $i = floor($e / (8 * $g->q / $t));
    $ig->init($i);
    $r['angle'] += 2 * $ig->random() * M_PI / $t;
    $r['intensity'] += ($ig->random() - 0.5) / $t;
}

function ng($e,$ig){
    $t = ['angle'=>0,'intensity'=>0.5];
    ag($e,1,$t,$ig);
    ag($e,2,$t,$ig);
    ag($e,4,$t,$ig);
    ag($e,8,$t,$ig);
    $t['intensity'] = max(0, min(1, $t['intensity']));
    $t['angle'] = fmod(180 * $t['angle'] / M_PI, 360);
    return $t;
}

// exposed functions
function getWeathersAt($idx){
    // If a world seed option exists, use it to derive a deterministic offset
    $numericSeed = jotunheim_get_numeric_seed();
    $ig = new Yj(0);
    // combine index with numeric seed to produce per-world weather sequence
    $weatherSeed = intval(floor((($idx + $numericSeed) * 125) / 666));
    return og($weatherSeed, $ig);
}

function getGlobalWind($idx){
    $numericSeed = jotunheim_get_numeric_seed();
    $ig = new Yj(0);
    // combine index with numeric seed so wind sequence is world-specific
    return ng(($idx + $numericSeed) * 125, $ig);
}

// Helper: Read stored world seed option and convert to a 32-bit numeric seed.
function jotunheim_get_numeric_seed(){
    // Attempt to read option; fall back to 0
    $seed = get_option('jotunheim_world_seed', '');
    if (!$seed) return 0;
    // If the seed is purely numeric, use its modulo 2^31 value
    if (is_numeric($seed)) {
        return intval($seed) & 0x7FFFFFFF;
    }
    // Otherwise compute a simple crc32-like integer from the string
    $hash = crc32($seed);
    // crc32 can return negative on 32-bit PHP; ensure unsigned
    return $hash & 0x7FFFFFFF;
}

// end of file
