<?php

namespace App\Helpers;
use App\Models\Initiation;
use App\Models\InitiativeGuru;
use App\Models\Devotees;
use App\Models\Branch;
use App\Models\Mentor;
use App\Models\AttendSewa;
use App\Models\YatraPayment;
use App\Models\YatraDocuments;
use App\Models\CourseFacilitator;
use App\Models\CourseBatch;
use App\Models\Donation;
use App\Models\DevoteeFamilyMember;
use App\Models\GuestTakeCare;

class Helper
{
  public static function decryptvalue($value)
  {
      $getdata = Crypt::decrypt($value);
      return $getdata;
  }
  public static function getfamilydevoteeidsame($id)
  {
      $getdata = DevoteeFamilyMember::where('devotee_id', $id)->where('devotees_id', $id)->exists();
      return $getdata;
  }
  public static function getmemberusingdevoteeexists($gid)
  {
      $getdata = DevoteeFamilyMember::where('devotee_id', $gid)->exists();
      return $getdata;
  }
  public static function getmemberusingdevoteedoesntexists($gid)
  {
      $getdata = DevoteeFamilyMember::where('devotee_id', $gid)->doesntExist();
      return $getdata;
  }
  public static function getmemberusingdevoteeid($gid)
  {
      $getdata = DevoteeFamilyMember::where('devotee_id', $gid)->first();
      return $getdata;
  }
  public static function getalldevoteemembers($gid)
  {
      $getdata = DevoteeFamilyMember::where('devotees_id', $gid)->get();
      return $getdata;
  }
  public static function getdevoteebyfacilitator($id)
  {
      $getfacilitator = CourseFacilitator::find($id);
      $getdevotee = Devotees::find($getfacilitator->devotee_id);
      return $getdevotee;
  }
  public static function getinitiationrow($devoteeid)
  {
      $initiationrow = Initiation::where('devotee_id', $devoteeid)->where('initiation_type', 'Harinam Initiation')->first();
      return $initiationrow;
  }
  public static function getbranchbydevoteeid($branchid)
  {
      $getbranch = Branch::find($branchid);
      return $getbranch;
  }
  public static function getbranchbydevotee($devoteeid)
  {
    $getdevotee = Devotees::find($devoteeid);
    $getbranch = Branch::find($getdevotee->branch_id);
    return $getbranch;
  }
  public static function getdevoteebymentor($id)
  {
      $getmentor = Mentor::find($id);
      $getdevotee = Devotees::find($getmentor->devotee_id);
      return $getdevotee;
  }
  public static function getdevoteebyguesttakecare($id)
  {
      $getmentor = GuestTakeCare::find($id);
      $getdevotee = Devotees::find($getmentor->devotee_id);
      return $getdevotee;
  }
  public static function getdevoteebyinitiationguruid($id)
  {
    $initiationrow = InitiativeGuru::find($id);
    $getdevotee = Devotees::find($initiationrow->name);
    return $getdevotee;
  }
  public static function getdevoteebyid($id)
  {
      $getdevotee = Devotees::find($id);
      return $getdevotee;
  }
  public static function getdevoteeonservicedepartment($id)
  {
      $lists = AttendSewa::where('department_id', $id)->get();
      return $lists;
  }
  public static function getinitiatedevotees($id)
  {
      $lists = Initiation::where('initiation_guru_id', $id)->where('initiation_type', 'Sheltered')->get();
      return $lists;
  }
  public static function getyatrapayment($seasonid, $devoteeid)
  {
      $lists = YatraPayment::where('yatra_seasons_id', $seasonid)->where('devotee_id', $devoteeid)->get();
      return $lists;
  }
  public static function getyatradocuments($seasonid, $devoteeid)
  {
      $lists = YatraDocuments::where('yatra_seasons_id', $seasonid)->where('devotee_id', $devoteeid)->get();
      return $lists;
  }
  public static function getfacilitatorbycourseid($courseid)
  {
      $lists = CourseFacilitator::where('course_id', $courseid)->get();
      return $lists;
  }
  public static function getcoursebatchpayment($seasonid, $devoteeid)
  {
      $lists = Donation::where('course_batch_id', $seasonid)->where('devotee_id', $devoteeid)->get();
      return $lists;
  }
  public static function getcourcebatch($id)
  {
      $get = CourseBatch::Find($id);
      return $get;
  }

}
