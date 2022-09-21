<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::paginate(getPaginate(10));
        $pageTitle = 'All Advertisements';
        $emptyMessage = 'No advertisement found.';
        return view('admin.advertisement.index', compact('advertisements', 'pageTitle', 'emptyMessage'));
    }


    public function store(Request $request)
    {
        $validation = [
            'type'               => 'required',
            'size'               => 'required',
            'image'              => ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png', 'gif'])],
        ];

        //==========validation for request image ===============
        $conditionalValidation = $this->advertisementValidation($request);

        ///===========marge request validation =================
        $validation = array_merge($validation, $conditionalValidation);

        $request->validate($validation);

        $value = "";

        //========upload image if request has ================
        if ($request->hasFile('image')) {
            $value = uploadFile($request->file('image'), imagePath()['advertisement']['path']);
        } else {
            $value = $request->script;
        }

        $advertisement = new Advertisement();
        $advertisement->type = $request->type;
        $advertisement->value = $value;
        $advertisement->size = $request->size;
        $advertisement->redirect_url = $request->redirect_url;
        $advertisement->save();
        $notify[] = ['success', 'Currency Created Successfully'];
        return redirect()->route('admin.advertisement.index')->withNotify($notify);
    }


    public function update(Request $request, $id)
    {
        $validation = [
            'type'               => 'required',
            'size'               => 'required',
            'image'              => ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png', 'gif'])],
        ];


        $advertisement = Advertisement::findOrFail($id);
        $value = $advertisement->value;

        $conditionalValidation = [];

        //=======validation request data, if file upload,type change or change image size ===================
        if ($request->type == "image"  && $request->hasFile('image') || $request->size != $advertisement->image_size || $advertisement->type = 'script' && $request->type == 'image'){
            $conditionalValidation = $this->advertisementValidation($request, 'nullable');
        }

        $validation = array_merge($validation, $conditionalValidation);
        $request->validate($validation);

        if ($request->hasFile('image')) {

            /////=================upload new image==================
            $value = uploadFile($request->file('image'), imagePath()['advertisement']['path']);


            ///===================Remove Old Image===============
            $oldImage = $advertisement->value;
            removeFile(imagePath()['advertisement']['path'] . '/' . $oldImage);
        }
        if ($request->type == "script") {
            $value = $request->script;
        }
        $advertisement->type = $request->type;
        $advertisement->value = $value;
        $advertisement->size = $request->size;
        $advertisement->redirect_url = $request->redirect_url;
        $advertisement->status = $request->status ? 1 : 0;
        $advertisement->save();
        $notify[] = ['success', 'Advertisement Updated Successfully'];
        return redirect()->route('admin.advertisement.index')->withNotify($notify);
    }

    public function delete(Request $request){
        $advertisement = Advertisement::findOrFail($request->advertisement_id);
        $advertisement->delete();
        
        $notify[] = ['success', 'Advertisement Deleted Successfully'];
        return back()->withNotify($notify);
    }

    public function advertisementValidation($request, $imgValidation = 'required')
    {
        $validation = [];
        if ($request->type == "image") {
            $size = explode('x', $request->size);
            $validation = [
                'size'               => 'required',
                'image'              => [$imgValidation, 'image', 'dimensions:width=' . $size[0] . ',height=' . $size[1]],
            ];
        } else {
            $validation = [
                'script'              => 'required',
            ];
        }

        return $validation;
    }

}
