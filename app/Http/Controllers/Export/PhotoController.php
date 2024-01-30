<?php

namespace App\Http\Controllers\Export;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ManifestExp as DBManifest;
use App\Models\ContainerExp as DBContainer;
use App\Models\Photo as DBPhoto;

class PhotoController extends Controller
{
    public function IndexContainer()
    {
        if ( !$this->access->can('show.lcl.manifest.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index EXP Manifest', 'slug' => 'show.lcl.manifest.index', 'description' => ''));
        
        $data['page_title'] = "Photo Container";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Photo Container'
            ]
        ];        
        
        $data['container'] = DBContainer::orderBy('TGLMASUK', 'desc')->get();
       
        return view('export.photo.container')->with($data);
    }

    public function IndexManifest()
    {
        if ( !$this->access->can('show.lcl.manifest.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index EXP Manifest', 'slug' => 'show.lcl.manifest.index', 'description' => ''));
        
        $data['page_title'] = "Photo Manifest";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Photo Manifest'
            ]
        ];        
        
        $data['manifest'] = DBManifest::orderBy('TGL_PACK', 'desc')->get();
      

        return view('export.photo.manifest')->with($data);
    }


    public function PhotoCont($id)
    {
        if ( !$this->access->can('show.lcl.manifest.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index EXP Manifest', 'slug' => 'show.lcl.manifest.index', 'description' => ''));
        
        $NOCONTAINER = DBContainer::where('TCONTAINER_PK', $id)->first();
        $data['page_title'] = "Photo Container ||".$NOCONTAINER->NOCONTAINER;
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Photo Container'
            ]
        ];        
        $data['container'] = DBContainer::where('TCONTAINER_PK', $id)->pluck('TCONTAINER_PK')->first();
        $data['photo'] = DBPhoto::where('type', '=', 'container')->where('id', $id)->orderBy('activity', 'desc')->orderBy('upload_at', 'desc')->get();
       
        return view('export.photo.container.upload')->with($data);
    }

    public function PhotoManifestView($id)
    {
        if ( !$this->access->can('show.lcl.manifest.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index EXP Manifest', 'slug' => 'show.lcl.manifest.index', 'description' => ''));
        
        $NOPACKING = DBManifest::where('TMANIFEST_PK', $id)->first();
        $data['page_title'] = "Photo Cargo ||".$NOPACKING->NO_PACK;
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Photo Cargo'
            ]
        ];        
        $data['manifest'] = DBManifest::where('TMANIFEST_PK', $id)->pluck('TMANIFEST_PK')->first();
        $data['photo'] = DBPhoto::where('type', '=', 'manifest')->where('id', $id)->orderBy('activity', 'desc')->orderBy('upload_at', 'desc')->get();
       
        return view('export.photo.manifest.upload')->with($data);
    }

    public function getContainer($id, Request $request)
    {
        $cont = DBContainer::where('TCONTAINER_PK', $id)->first();

        if ($cont) {
            return response()->json(['success' => true, 'message' => 'Data ditemukan', 'data'=>$cont]);
        }
    }

    public function PhotoContainer(Request $request)
    {
        

        $ket = $request->keterangan;
      
        $id = $request->TCONTAINER_PK;
        $file = $request->photo;
        $waktuSekarang = time();
        $time = date('Y-m-d', $waktuSekarang);
        $extension = $file->getClientOriginalExtension();  
        $name = $file->getClientOriginalName();
        $fileName = $id . '_'. $time. '_' . $ket . '-'. $name;
        $destination = base_path(). '/public/uploads/photos/export/container';
        
       

        $cont = DBContainer::where('TCONTAINER_PK', $id)->first();
        if ($cont) {

            $photo = DBPhoto::where('type', '=', 'container')->where('id', $id)->where('activity', $ket)->count();
            if ($photo < 4) {
                $photo = DBPhoto::create([
                    'type' => 'container',
                    'activity'=> $ket,
                    'id' => $id,
                    'photo' => $fileName,
                    'UID' =>  \Auth::getUser()->name,
                ]);        
                $img = \Image::make($file)->orientate();
    
                // resize the image to a width of 300 and constrain aspect ratio (auto height)
                $img->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
    
                $img->save($destination.'/'. $fileName);
                return response()->json(['success' => true, 'message' => 'Data ditemukan', 'data'=>$photo]);
               
            }else {
                return response()->json(['success' => false, 'message' => 'Sudah Melebihi Kapasitas']);
            }

            
        }else {
            return response()->json(['success' => false, 'message' => 'Something Wrong']);
        }
    }


    public function getManifest($id, Request $request)
    {
        $mani = DBManifest::where('TMANIFEST_PK', $id)->first();

        if ($mani) {
            return response()->json(['success' => true, 'message' => 'Data ditemukan', 'data'=>$mani]);
        }
    }

    public function PhotoManifest(Request $request)
    {
        

        $ket = $request->keterangan;
        $id = $request->TMANIFEST_PK;
        $file = $request->photo;
        $waktuSekarang = time();
        $time = date('Y-m-d', $waktuSekarang);
        $extension = $file->getClientOriginalExtension();
        $name = $file->getClientOriginalName();
        $fileName = $id . '_'. $time. '_' . $ket . '-'. $name;
        $destination = base_path(). '/public/uploads/photos/export/manifest';
        
       

        $cont = DBManifest::where('TMANIFEST_PK', $id)->first();
        if ($cont) {
            $photo = DBPhoto::where('type', '=', 'manifest')->where('id', $id)->where('activity', $ket)->count();
            if ($photo < 4) {
                $photo = DBPhoto::create([
                    'type' => 'manifest',
                    'activity'=> $ket,
                    'id' => $id,
                    'photo' => $fileName,
                    'UID' =>  \Auth::getUser()->name,
                ]);        
                $img = \Image::make($file)->orientate();
    
                // resize the image to a width of 300 and constrain aspect ratio (auto height)
                $img->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
    
                $img->save($destination.'/'. $fileName);
                return response()->json(['success' => true, 'message' => 'Data ditemukan', 'data'=>$photo]);
               
            }else {
                return response()->json(['success' => false, 'message' => 'Sudah Melebihi Kapasitas']);
            }
            return response()->json(['success' => true, 'message' => 'Data ditemukan', 'data'=>$cont]);
        }else {
            return response()->json(['success' => false, 'message' => 'Something Wrong']);
        }
    }

    public function printPhoto($id)
    {
        $data['gateIn'] = DBPhoto::where('type', '=', 'container')->where('id', $id)->where('activity', '=', 'gateIn')->get();
        $data['gateOut'] = DBPhoto::where('type', '=', 'container')->where('id', $id)->where('activity', '=', 'gateOut')->get();
        $data['stuffing'] = DBPhoto::where('type', '=', 'container')->where('id', $id)->where('activity', '=', 'stuffing')->get();
        $data['photos'] = DBContainer::where('TCONTAINER_PK', $id)->first();
        // dd($barcode);
        return view('print.photo')->with($data);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        $photo = DBPhoto::where('photo_id', $id)->first();
        if ($photo) {

            $photoPath = public_path('uploads/photos/export/container/') . $photo->photo;
        if (file_exists($photoPath)) {
            unlink($photoPath);
        }
            $photo->delete([

            ]);
            return response()->json(['success' => true, 'message' => 'Data ditemukan']);
        }
    }
}
