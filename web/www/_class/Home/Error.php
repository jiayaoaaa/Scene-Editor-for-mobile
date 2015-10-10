<?PHP

class Home_Error extends Sp_Web_Action_Abstract
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
       	$view = new Sp_View;
		$view->out_404();
    }

}