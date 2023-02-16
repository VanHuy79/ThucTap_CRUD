<?php

namespace App\Repositories;

//Nơi triển khai các hàm để truy vấn với DB
// Các lớp khác có thể kế thừa và sử dụng các phương thức chung
// Triển khai các phương thức cơ bản của Repo
abstract class BaseRepositories implements RepositoriesInterface
{
   // Trỏ đến model cụ thể
   protected $model;

   public function __construct()
   {
      $this->model = app()->make(
         // Sẽ được nhắc lại bởi các Post và File
         $this->getModel()
      );
   }
   //Được sử dụng cho các lớp kế thừa
   abstract public function getModel();


   public function all()
   {
      return $this->model->all();
   }

   public function find($id)
   {
      return $this->model->find($id);
   }

   public function create(array $data)
   {
      return $this->model->create($data);
   }

   public function update($data = [], $id)
   {
      $result = $this->find($id);
      if ($result) {
         $result->update($data);
         return $result;
      }
      return false;
      // $object = $this->model->find($id);
      // return $object->update($data);
   }

   public function delete($id)
   {
      // $object = $this->model->find($id);
      // return $object->delete();
      $result = $this->find($id);
      if ($result) {
         $result->delete();

         return true;
      }

      return false;
   }
}
