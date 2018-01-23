<?php

namespace App\Service;

use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;
use Illuminate\Database\Eloquent\Model;


/**
 * Created by PhpStorm.
 * User: lanzongjun
 * Date: 2018/1/23
 * Time: 下午3:12
 */

class ExcelService extends BaseService
{
    /*
     * 导出excel
     * PARAM:
     * $data   导出数据
     * $excel_name   表名
     * $sheet_name   sheet名
     * $is2007    导出是否为xlsx格式,true为xlsx,false为xls
     */
    public static function ExportExcel($data, $excel_name, $sheet_name, $is2007) {
        if ($is2007) {
            $style = 'xlsx';
        } else {
            $style = 'xls';
        }
        if (is_null($data) || count($data) == 0 ) {
            return null;
        }
        /** @var Excel $excel */
        $excel = app(Excel::class);

        $excel->create($excel_name, function($excel) use ($data,$sheet_name){
            /** @var LaravelExcelWriter $excel */
            $excel->sheet($sheet_name, function($sheet) use ($data) {
                if ($data[0] instanceof Model) {
                    /** @var LaravelExcelWorksheet $sheet */
                    $sheet->fromModel($data);
                } else if (is_array($data)) {
                    /** @var LaravelExcelWorksheet $sheet */
                    $sheet->fromArray($data);
                } else {
                    throw new Exception("excel 参数传入错误", -1);
                }
            });

        })->export($style);
    }


    /*
    * 存excel
    * PARAM:
    * $data   导出数据
    * $excel_name   表名
    * $sheet_name   sheet名
    * $is2007    导出是否为xlsx格式,true为xlsx,false为xls
    */
    public static function StoreExcel($data, $excel_name, $sheet_name, $is2007) {
        if ($is2007) {
            $style = 'xlsx';
        } else {
            $style = 'xls';
        }
        if (is_null($data) || count($data) == 0 ) {
            return null;
        }
        /** @var Excel $excel */
        $excel = app(Excel::class);
        $excel->create($excel_name, function($excel) use ($data,$sheet_name){
            /** @var LaravelExcelWriter $excel */
            $excel->sheet($sheet_name, function($sheet) use ($data) {
                if ($data[0] instanceof Model) {
                    /** @var LaravelExcelWorksheet $sheet */
                    $sheet->fromModel($data);
                } else if (is_array($data)) {
                    /** @var LaravelExcelWorksheet $sheet */
                    $sheet->fromArray($data);
                } else {
                    throw new Exception("excel 参数传入错误", -1);
                }
            });

        })->store($style);
    }
}