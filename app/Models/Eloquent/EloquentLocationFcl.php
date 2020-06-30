<?php
namespace App\Models\Eloquent;

class EloquentLocationFcl {
 
  /**
   * LocationFcl Eloquent Model
   *
   * @var  LocationFcl
   *
   */
    protected $LocationFcl;
 
    public function __construct()
    {
        $this->LocationFcl = new \App\Models\LocationFcl();
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
//        $this->LocationFcl->create($data);
        $this->LocationFcl->insertGetId($data);
      }
      catch (Exception $e)
      {
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
      }
 
      return json_encode(array('success' => true, 'message' => 'Location Fcl successfully saved!'));
    }
 
    /**
     * Updates an existing roles
     *
     * @param  int $id LocationFcl id
     * @param  array $data
     * 	An array as follows: array('name'=>$name, 'description'=>$description, 'author'=>$author, 'publisher'=>$publisher, 'language'=>$language, 'length'=>$length, 'asin'=>$asin);
     *
     * @return  boolean
     */
    public function update($id, array $data)
    {
      $LocationFcl = $this->LocationFcl->find($id);
      $data['uid'] = \Auth::getUser()->name;
      
      foreach ($data as $key => $value)
      {
        $LocationFcl->$key = $value;
      }
 
      try
      {
        $LocationFcl->save();
      }
      catch (Exception $e)
      {
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
      }
 
      return json_encode(array('success' => true, 'message' => 'Location Fcl successfully updated!'));
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
        $this->LocationFcl->destroy($id);
      }
      catch (Exception $e)
      {
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
      }
 
      return json_encode(array('success' => true, 'message' => 'Location Fcl successfully deleted!'));
    }
}
