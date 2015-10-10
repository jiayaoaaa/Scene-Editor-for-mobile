<?PHP

class Home_Index extends Sp_Web_Action_Abstract
{
    protected $condition = array();
	
    /**
     * function description
     *
     * @param
     * @return void
     */
    public function execute($request)
    {
		
        if ($request->format == 'json') {
        	$arrary = array();		
			return $array;
        } else {

			$view = new Sp_View;
            $view->display("index.html");
        }

    }

}