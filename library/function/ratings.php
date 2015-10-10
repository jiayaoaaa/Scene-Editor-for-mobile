<?PHP

// $Id$

/**
/* 关于Rating的一个算法
 * http://www.evanmiller.org/how-not-to-sort-by-average-rating.html
 * 
 * 
 * 
 */

// main
if(isset($_SERVER['argc']) && isset($_SERVER['argv'][0]))
{
	$pos = 10; $n = 100; $power = 0.05;

	if(isset($_SERVER['argv'][1])) $pos = intval($_SERVER['argv'][1]);
	if(isset($_SERVER['argv'][2])) $n = intval($_SERVER['argv'][2]);

	var_dump(ci_lower_bound($pos, $n, $power));
}



/**
def ci_lower_bound(pos, n, power)
    if n == 0
        return 0
    end
    z = Statistics2.pnormaldist(1-power/2)
    phat = 1.0*pos/n
    (phat + z*z/(2*n) - z * Math.sqrt((phat*(1-phat)+z*z/(4*n))/n))/(1+z*z/n)
end
*/
// pos is the number of positive rating, n is the total number of ratings, and power refers to the statistical power: I would pick 0.05.
/**
 * function description
 * 
 * @param
 * @return void
 */
 function ci_lower_bound($pos, $n, $power)
{
	if ($n == 0)
	{
		return 0;
	}
	$z = pnorm(1-$power/2);
	$phat = 1.0*$pos/$n;
	
	return ($phat + $z*$z/(2*$n) - $z * sqrt(($phat*(1-$phat)+$z*$z/(4*$n))/$n))/(1+$z*$z/$n);
}



/**
  def pnorm(qn)
    b = [1.570796288, 0.03706987906, -0.8364353589e-3,
         -0.2250947176e-3, 0.6841218299e-5, 0.5824238515e-5,
         -0.104527497e-5, 0.8360937017e-7, -0.3231081277e-8,
         0.3657763036e-10, 0.6936233982e-12]
    
    if(qn < 0.0 || 1.0 < qn)
      $stderr.printf("Error : qn <= 0 or qn >= 1  in pnorm()!\n")
      return 0.0;
    end
    qn == 0.5 and return 0.0
    
    w1 = qn
    qn > 0.5 and w1 = 1.0 - w1
    w3 = -Math.log(4.0 * w1 * (1.0 - w1))
    w1 = b[0]
    1.upto 10 do |i|
      w1 += b[i] * w3**i;
    end
    qn > 0.5 and return Math.sqrt(w1 * w3)
    -Math.sqrt(w1 * w3)
  end
*/
/**
 * function description
 * 
 * @param
 * @return void
 */
 function pnorm($qn)
{
	$b = array(1.570796288, 0.03706987906, -0.8364353589e-3,
         -0.2250947176e-3, 0.6841218299e-5, 0.5824238515e-5,
         -0.104527497e-5, 0.8360937017e-7, -0.3231081277e-8,
         0.3657763036e-10, 0.6936233982e-12);
	if ($qn < 0.0 || 1.0 < $qn)
	{
		error_log("Error : qn <= 0 or qn >= 1  in pnorm()!\n");
		return 0.0;
	}
	if ($qn == 0.5)
	{
		return 0.0;
	}
	$w1 = $qn;
	if ($qn > 0.5)
	{
		$w1 = 1.0 - $w1;
	}
	$w3 = 0 - log(4.0 * $w1 * (1.0 - $w1));
	$w1 = $b[0];
	for($i = 1; $i <= 10; $i ++) {
		$w1 += $b[$i] * pow($w3, $i);
	}
	$r = sqrt($w1 * $w3);
	if($qn > 0.5) return $r;
	else return 0 - $r;
}
