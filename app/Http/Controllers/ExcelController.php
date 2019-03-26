<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\File;

class ExcelController extends Controller
{
    protected $dataFile = [];
    public function index(){
        return view('excel.index');
    }

    /**
     * Excel convert Json
     * @author Tanmnt
     * @param request
     * @return json
     */
    public function excelJson(Request $request){
        if($request->hasFile('file_import')){
            $path = $request->file('file_import')->getRealPath();
            Excel::load($path, function($reader) {
                // $heading = $reader->first()->keys()->toArray();
                foreach($reader->get() as $key => $sheet)
                {
                    /**
                     * Khai báo cột trên excel
                     */
                    $id = $sheet->id;   
                    $type1 = $sheet->tag_type1;
                    $data1 = $sheet->tag_data1;
                    $type2 = $sheet->tag_type2;
                    $data2 = $sheet->tag_data2;
                    $type3 = $sheet->tag_type3;
                    $data3 = $sheet->tag_data3;
                    $type4 = $sheet->tag_type4;
                    $data4 = $sheet->tag_data4;
                    $type5 = $sheet->tag_type5;
                    $data5 = $sheet->tag_data5;
                    $type6 = $sheet->tag_type6;
                    $data6 = $sheet->tag_data6;
                    $type7 = $sheet->tag_type7;
                    $data7 = $sheet->tag_data7;
                    $type8 = $sheet->tag_type8;
                    $data8 = $sheet->tag_data8;
                    $type9 = $sheet->tag_type9;
                    $data9 = $sheet->tag_data9;
                    $type10 = $sheet->tag_type10;
                    $data10 = $sheet->tag_data10;
    
                    /**
                     * Kiểm tra mảng có null không
                     */
                    $array1 = $this->checkNull($type1, $data1);
                    $array2 = $this->checkNull($type2, $data2);
                    $array3 = $this->checkNull($type3, $data3);
                    $array4 = $this->checkNull($type4, $data4);
                    $array5 = $this->checkNull($type5, $data5);
                    $array6 = $this->checkNull($type6, $data6);
                    $array7 = $this->checkNull($type7, $data7);
                    $array8 = $this->checkNull($type8, $data8);
                    $array9 = $this->checkNull($type9, $data9);
                    $array10 = $this->checkNull($type10, $data10);
                    
                    /**
                     * return định dạng Json
                     */
                    $arrayJson[] = [
                        'id' => $id,
                        'tag_setting' => [
                            $array1,
                            $array2,
                            $array3,
                            $array4,
                            $array5,
                            $array6,
                            $array7,
                            $array8,
                            $array9,
                            $array10,
                        ]
                    ];
                }
    
                /**
                 * Xóa array empty
                 */
                foreach($arrayJson as $key_js => $js){
                    foreach($js["tag_setting"] as $key => $tag_setting){
                        if(empty($arrayJson[$key_js]["tag_setting"][$key])){
                            unset($arrayJson[$key_js]["tag_setting"][$key]);
                        }
                    }
                    $array_value = array_values($arrayJson[$key_js]["tag_setting"]);
                    $arrayJsonNoEmpty[] = [
                        'id' => $js["id"],
                        'tag_setting' => $array_value
                    ];
                }
                /**
                 * return json
                 */
                $response =  json_encode($arrayJsonNoEmpty, JSON_PRETTY_PRINT|JSON_HEX_QUOT|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_TAG);
                header('Content-Type: application/json; charset="utf-8"');
                die($response);
            })->get();
        }else{
            return redirect()->back();
        }
    }

    public function getTranslate() {
        return view('excel.translate');
    }

    public function postTranslate(Request $request) {

        if($request->hasFile('file_import')){
            $path = $request->file('file_import')->getRealPath();
            Excel::load($path, function($reader) {
                foreach ($reader->get() as $key => $value) {
                    if($value['file']) {
                        $myFile = fopen(resource_path('lang/en/' . $value['file']), "w");
                        fwrite($myFile, "<?php\nreturn [\n");
                        $this->dataFile[] = resource_path('lang/en/' . $value['file']);
                    }
                    if($value['key']){
                        $keyArray = $value['key'];
                        $valueArray = $value['en'];
                        fwrite($myFile, "\t'".$keyArray."' => '".$valueArray."',\n");
                    }
                }
            })->get();
            foreach ($this->dataFile as $file) {
                $myFileTemp = fopen($file, "a+");
                fwrite($myFileTemp, "];");
            }
            echo "Success";
        }else{
            return redirect()->back();
        }
    }

    /**
     * Kiểm tra có type data có giá trị không
     * @param type,data  
     * @return Array
     */
    private function checkNull($type, $data){
        $array = array();
        if($type != null && $data != null){
            $array = [
                'tag_type' => $type,
                'tag_data' => $data,
            ];
            return $array;
        }
        return $array;
    }
}
