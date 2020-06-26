<?php
namespace App\Models\Eloquent;

class EloquentPpjk {
 
  /**
   * Ppjk Eloquent Model
   *
   * @var  Ppjk
   *
   */
    protected $Ppjk;
 
    public function __construct()
    {
        $this->Ppjk = new \App\Models\Ppjk();
    }
 
     /**
     * Creates a new roles
     *
     * @param  array $data
     * 	An array as follows: array('name'=>$name, 'description'=>$description, 'author'=>$author, 'publisher'=>$publisher, 'language'=>$language, 'length'=>$length, 'asin'=>$asin);
     *
     * @return  boolean
     */
    public function create(array $data)
    {
        $data['uid'] = \Auth::getUser()->name;
      try
      {
//        $this->Ppjk->create($data);
        $this->Ppjk->insertGetId($data);
      }
      catch (Exception $e)
      {
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
      }
 
      return json_encode(array('success' => true, 'message' => 'PPJK successfully saved!'));
    }
 
    /**
     * Updates an existing roles
     *
     * @param  int $id Ppjk id
     * @param  array $data
     * 	An array as follows: array('name'=>$name, 'description'=>$description, 'author'=>$author, 'publisher'=>$publisher, 'language'=>$language, 'length'=>$length, 'asin'=>$asin);
     *
     * @return  boolean
     */
    public function update($id, array $data)
    {
      $Ppjk = $this->Ppjk->find($id);
      $data['uid'] = \Auth::getUser()->name;
      
      foreach ($data as $key => $value)
      {
        $Ppjk->$key = $value;
      }
 
      try
      {
        $Ppjk->save();
      }
      catch (Exception $e)
      {
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
      }
 
      return json_encode(array('success' => true, 'message' => 'Ppjk successfully updated!'));
    }
 
    /**
     * Deletes an existing roles
     *
     * @param  int id
     *
     * @return  boolean
     */
    public function delete($id)
    {
      try
      {
        $this->Ppjk->destroy($id);
      }
      catch (Exception $e)
      {
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
      }
 
      return json_encode(array('success' => true, 'message' => 'PPJK successfully deleted!'));
    }
}
