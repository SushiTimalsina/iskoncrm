<?php

namespace App\Imports;

use App\Models\Devotees;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\Rule;

class DevoteeImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure
{
  use Importable, SkipsErrors, SkipsFailures;
  /**
  * @param array $row
  *
  * @return \Illuminate\Database\Eloquent\Model|null
  */
  public function model(array $row)
  {
    $user = auth()->user();
    $devoteerow = Devotees::find($user->devotee_id);

        if($row['email'] != NULL){
          $hashemail = hash('sha256', $row['email']);
          $email = Crypt::encrypt($row['email']);
        }else{
          $hashemail = NULL;
          $email = NULL;
        }

        if($row['mobile'] != NULL){
          $hashmobile = hash('sha256', $row['mobile']);
          $mobile = Crypt::encrypt($row['mobile']);
        }else{
          $hashmobile = NULL;
          $mobile = NULL;
        }

        if($row['firstname'] != NULL){ $firstname = Crypt::encrypt($row['firstname']); }else{ $firstname = NULL; }
        if($row['middlename'] != NULL){ $middlename = Crypt::encrypt($row['middlename']); }else{ $middlename = NULL; }
        if($row['surname'] != NULL){ $surname = Crypt::encrypt($row['surname']); }else{ $surname = NULL; }

    return new Devotees([
      'firstname' => $firstname,
      'middlename' => $middlename,
      'surname' => $surname,
      'gotra' => $row['gotra'],
      'email' => $hashemail,
      'email_enc' => $email,
      'mobile' => $hashmobile,
      'mobile_enc' => $mobile,
      'phone' => $row['phone'],
      'gender' => $row['gender'],
      'bloodgroup' => $row['bloodgroup'],
      'education' => $row['education'],
      'branch_id' => $user->branch_id,
      'createdby' => $user->id,
      'status' => 'imported'
    ]);
  }

  /**
  * @return array
  */
  public function rules(): array
  {
      return [
          '*.email' => ['email', 'unique:devotees,email'],
          '*.mobile' => ['unique:devotees,mobile']
      ];
  }
}
