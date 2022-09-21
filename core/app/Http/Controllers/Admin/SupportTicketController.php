<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class SupportTicketController extends Controller
{
    public function userTickets()
    {
        $pageTitle = 'Support Tickets';
        $emptyMessage = 'No Data found.';
        $items = SupportTicket::orderBy('id','desc')->where('user_id', '!=', 0)->with('user')->paginate(getPaginate());
        return view('admin.support.user_tickets', compact('items', 'pageTitle','emptyMessage'));
    }

    public function userTendingTicket()
    {
        $pageTitle = 'Pending Tickets';
        $emptyMessage = 'No Data found.';
        $items = SupportTicket::whereIn('status', [0,2])->orderBy('priority', 'DESC')->orderBy('id','desc')->where('user_id', '!=', 0)->with('user')->paginate(getPaginate());
        return view('admin.support.user_tickets', compact('items', 'pageTitle','emptyMessage'));
    }

    public function userClosedTicket()
    {
        $emptyMessage = 'No Data found.';
        $pageTitle = 'Closed Tickets';
        $items = SupportTicket::where('status',3)->orderBy('id','desc')->where('user_id', '!=', 0)->with('user')->paginate(getPaginate());
        return view('admin.support.user_tickets', compact('items', 'pageTitle','emptyMessage'));
    }

    public function userAnsweredTicket()
    {
        $pageTitle = 'Answered Tickets';
        $emptyMessage = 'No Data found.';
        $items = SupportTicket::orderBy('id','desc')->where('user_id', '!=', 0)->with('user')->where('status',1)->paginate(getPaginate());
        return view('admin.support.user_tickets', compact('items', 'pageTitle','emptyMessage'));
    }


    public function userTicketReply($id)
    {
        $ticket = SupportTicket::with('user')->where('id', $id)->firstOrFail();
        $pageTitle = 'Reply Ticket';
        $messages = SupportMessage::with('ticket')->where('supportticket_id', $ticket->id)->orderBy('id','desc')->get();
        return view('admin.support.user_reply', compact('ticket', 'messages', 'pageTitle'));
    }
    public function userTicketReplySend(Request $request, $id)
    {
        $ticket = SupportTicket::with('user')->where('id', $id)->firstOrFail();
        $message = new SupportMessage();
        if ($request->replayTicket == 1) {

            $attachments = $request->file('attachments');
            $allowedExts = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx');

            $this->validate($request, [
                'attachments' => [
                    'max:4096',
                    function ($attribute, $value, $fail) use ($attachments, $allowedExts) {
                        foreach ($attachments as $attachment) {
                            $ext = strtolower($attachment->getClientOriginalExtension());
                            if (($attachment->getSize() / 1000000) > 2) {
                                return $fail("Miximum 2MB file size allowed!");
                            }

                            if (!in_array($ext, $allowedExts)) {
                                return $fail("Only png, jpg, jpeg, pdf, doc, docx files are allowed");
                            }
                        }
                        if (count($attachments) > 5) {
                            return $fail("Maximum 5 files can be uploaded");
                        }
                    }
                ],
                'message' => 'required',
            ]);
            $ticket->status = 1;
            $ticket->last_reply = Carbon::now();
            $ticket->save();

            $message->supportticket_id = $ticket->id;
            $message->admin_id = Auth::guard('admin')->id();
            $message->message = $request->message;
            $message->save();

            $path = imagePath()['ticket']['path'];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    try {
                        $attachment = new SupportAttachment();
                        $attachment->support_message_id = $message->id;
                        $attachment->attachment = uploadFile($file, $path);
                        $attachment->save();
                    } catch (\Exception $exp) {
                        $notify[] = ['error', 'Could not upload your ' . $file];
                        return back()->withNotify($notify)->withInput();
                    }
                }
            }

            notify($ticket, 'ADMIN_SUPPORT_REPLY', [
                'ticket_id' => $ticket->ticket,
                'ticket_subject' => $ticket->subject,
                'reply' => $request->message,
                'link' => route('ticket.view',$ticket->ticket),
            ]);

            $notify[] = ['success', "Support ticket replied successfully"];

        } elseif ($request->replayTicket == 2) {
            $ticket->status = 3;
            $ticket->save();
            $notify[] = ['success', "Support ticket closed successfully"];
        }
        return back()->withNotify($notify);
    }


    public function userTicketDownload($ticket_id)
    {
        $attachment = SupportAttachment::findOrFail(decrypt($ticket_id));
        $file = $attachment->attachment;


        $path = imagePath()['ticket']['path'];

        $full_path = $path.'/' . $file;
        $title = slug($attachment->supportMessage->ticket->subject).'-'.$file;
        $mimetype = mime_content_type($full_path);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($full_path);
    }
    public function userTicketDelete(Request $request)
    {
        $message = SupportMessage::findOrFail($request->message_id);
        $path = imagePath()['ticket']['path'];
        if ($message->attachments()->count() > 0) {
            foreach ($message->attachments as $attachment) {
                removeFile($path.'/'.$attachment->attachment);
                $attachment->delete();
            }
        }
        $message->delete();
        $notify[] = ['success', "Delete successfully"];
        return back()->withNotify($notify);

    }


    //Merchant
    public function merchantTickets()
    {
        $pageTitle = 'Support Tickets';
        $emptyMessage = 'No Data found.';
        $items = SupportTicket::orderBy('id','desc')->where('merchant_id', '!=', 0)->with('merchant')->paginate(getPaginate());
        return view('admin.support.merchant_tickets', compact('items', 'pageTitle','emptyMessage'));
    }

    public function merchantTendingTicket()
    {
        $pageTitle = 'Pending Tickets';
        $emptyMessage = 'No Data found.';
        $items = SupportTicket::whereIn('status', [0,2])->orderBy('priority', 'DESC')->orderBy('id','desc')->where('merchant_id', '!=', 0)->with('merchant')->paginate(getPaginate());
        return view('admin.support.merchant_tickets', compact('items', 'pageTitle','emptyMessage'));
    }

    public function merchantClosedTicket()
    {
        $emptyMessage = 'No Data found.';
        $pageTitle = 'Closed Tickets';
        $items = SupportTicket::where('status',3)->orderBy('id','desc')->where('merchant_id', '!=', 0)->with('merchant')->paginate(getPaginate());
        return view('admin.support.merchant_tickets', compact('items', 'pageTitle','emptyMessage'));
    }

    public function merchantAnsweredTicket()
    {
        $pageTitle = 'Answered Tickets';
        $emptyMessage = 'No Data found.';
        $items = SupportTicket::orderBy('id','desc')->where('merchant_id', '!=', 0)->with('merchant')->where('status',1)->paginate(getPaginate());
        return view('admin.support.merchant_tickets', compact('items', 'pageTitle','emptyMessage'));
    }


    public function merchantTicketReply($id)
    {
        $ticket = SupportTicket::with('merchant')->where('id', $id)->firstOrFail();
        $pageTitle = 'Reply Ticket';
        $messages = SupportMessage::with('ticket')->where('supportticket_id', $ticket->id)->orderBy('id','desc')->get();
        return view('admin.support.merchant_reply', compact('ticket', 'messages', 'pageTitle'));
    }
    public function merchantTicketReplySend(Request $request, $id)
    {
        $ticket = SupportTicket::with('merchant')->where('id', $id)->firstOrFail();
        $message = new SupportMessage();
        if ($request->replayTicket == 1) {

            $attachments = $request->file('attachments');
            $allowedExts = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx');

            $this->validate($request, [
                'attachments' => [
                    'max:4096',
                    function ($attribute, $value, $fail) use ($attachments, $allowedExts) {
                        foreach ($attachments as $attachment) {
                            $ext = strtolower($attachment->getClientOriginalExtension());
                            if (($attachment->getSize() / 1000000) > 2) {
                                return $fail("Miximum 2MB file size allowed!");
                            }

                            if (!in_array($ext, $allowedExts)) {
                                return $fail("Only png, jpg, jpeg, pdf, doc, docx files are allowed");
                            }
                        }
                        if (count($attachments) > 5) {
                            return $fail("Maximum 5 files can be uploaded");
                        }
                    }
                ],
                'message' => 'required',
            ]);
            $ticket->status = 1;
            $ticket->last_reply = Carbon::now();
            $ticket->save();

            $message->supportticket_id = $ticket->id;
            $message->admin_id = Auth::guard('admin')->id();
            $message->message = $request->message;
            $message->save();

            $path = imagePath()['ticket']['path'];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    try {
                        $attachment = new SupportAttachment();
                        $attachment->support_message_id = $message->id;
                        $attachment->attachment = uploadFile($file, $path);
                        $attachment->save();
                    } catch (\Exception $exp) {
                        $notify[] = ['error', 'Could not upload your ' . $file];
                        return back()->withNotify($notify)->withInput();
                    }
                }
            }

            notify($ticket, 'ADMIN_SUPPORT_REPLY', [
                'ticket_id' => $ticket->ticket,
                'ticket_subject' => $ticket->subject,
                'reply' => $request->message,
                'link' => route('ticket.view',$ticket->ticket),
            ]);

            $notify[] = ['success', "Support ticket replied successfully"];

        } elseif ($request->replayTicket == 2) {
            $ticket->status = 3;
            $ticket->save();
            $notify[] = ['success', "Support ticket closed successfully"];
        }
        return back()->withNotify($notify);
    }


    public function merchantTicketDownload($ticket_id)
    {
        $attachment = SupportAttachment::findOrFail(decrypt($ticket_id));
        $file = $attachment->attachment;


        $path = imagePath()['ticket']['path'];

        $full_path = $path.'/' . $file;
        $title = slug($attachment->supportMessage->ticket->subject).'-'.$file;
        $mimetype = mime_content_type($full_path);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($full_path);
    }
    public function merchantTicketDelete(Request $request)
    {
        $message = SupportMessage::findOrFail($request->message_id);
        $path = imagePath()['ticket']['path'];
        if ($message->attachments()->count() > 0) {
            foreach ($message->attachments as $attachment) {
                removeFile($path.'/'.$attachment->attachment);
                $attachment->delete();
            }
        }
        $message->delete();
        $notify[] = ['success', "Delete successfully"];
        return back()->withNotify($notify);

    }



}
