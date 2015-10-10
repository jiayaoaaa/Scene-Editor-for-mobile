<?PHP

interface Cache_Output_Interface
{
    public function start($key);
    public function end();
}
