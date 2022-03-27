<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\UserAppointment;
use App\Models\UserFavorite;
use App\Models\Worker;
use App\Models\WorkerPhotos;
use App\Models\workerServices;
use App\Models\WorkerTestimonial;
use App\Models\WorkerAvailability;

class WorkerController extends Controller
{
    private $loggedUser;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->loggedUser = auth()->user();
    }

    public function create(Request $request)
    {
        $array = ['error' => ''];
        //
        $newWorker = new Worker();
        $newWorker->name = "Valmir";
        $newWorker->avatar = "2.png";
        $newWorker->stars = 0.0;
        $newWorker->phone = "5584996667335";
        $newWorker->save();
        //
        $newworkerService = new workerServices();
        $newworkerService->id_worker = $newWorker->id;
        $newworkerService->name = "Pedreiro";
        $newworkerService->price = rand(1, 99) . '.' . rand(0, 100);
        $newworkerService->save();

        // $newWorkerTestimonial = new WorkerTestimonial();
        // $newWorkerTestimonial->id_Worker = $newWorker->id;
        // $newWorkerTestimonial->name = $names[rand(0, count($names) - 1)];
        // $newWorkerTestimonial->rate = rand(2, 4) . '.' . rand(0, 9);
        // $newWorkerTestimonial->body = $depos[rand(0, count($depos) - 1)];
        // $newWorkerTestimonial->save();

        for ($e = 0; $e < 4; $e++) {
            $rAdd = rand(7, 10);
            $hours = [];
            for ($r = 0; $r < 8; $r++) {
                $time = $r + $rAdd;
                if ($time < 10) {
                    $time = '0' . $time;
                }
                $hours[] = $time . ':00';
            }
            $newWorkerAvail = new WorkerAvailability();
            $newWorkerAvail->id_worker = $newWorker->id;
            $newWorkerAvail->weekday = $e;
            $newWorkerAvail->hours = implode(',', $hours);
            $newWorkerAvail->save();
        }

        return $array;
    }

    // private function searchGeo($address)
    // {
    //     $key = env('MAPS_KEY', null);

    //     $address = urlencode($address);
    //     $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=' . $key;
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     $res = curl_exec($ch);
    //     curl_close($ch);

    //     return json_decode($res, true);
    // }

    public function list(Request $request)
    {
        $array = ['error' => ''];

        // $lat = $request->input('lat');
        // $lng = $request->input('lng');
        // $city = $request->input('city');
        // $offset = $request->input('offset');
        // if (!$offset) {
        //     $offset = 0;
        // }

        // if (!empty($city)) {
        //     $res = $this->searchGeo($city);

        //     if (count($res['results']) > 0) {
        //         $lat = $res['results'][0]['geometry']['location']['lat'];
        //         $lng = $res['results'][0]['geometry']['location']['lng'];
        //     }
        // } elseif (!empty($lat) && !empty($lng)) {
        //     $res = $this->searchGeo($lat . ',' . $lng);

        //     if (count($res['results']) > 0) {
        //         $city = $res['results'][0]['formatted_address'];
        //     }
        // } else {
        //     $lat = '-6.2420251';
        //     $lng = '-36.5124361';
        //     $city = 'Currais Novos';
        // }

        // $workers = Worker::select(Worker::raw('*, SQRT(
        //     POW(69.1 * (latitude - ' . $lat . '), 2) +
        //     POW(69.1 * (' . $lng . ' - longitude) * COS(latitude / 57.3), 2)) AS distance'))
        //     ->havingRaw('distance < ?', [10])
        //     ->orderBy('distance', 'ASC')
        //     ->offset($offset)
        //     ->limit(10)
        //     ->get();

        $workers = Worker::all();

        foreach ($workers as $bkey => $bvalue) {
            $workers[$bkey]['avatar'] = url('media/avatars/' . $workers[$bkey]['avatar']);
        }

        $array['data'] = $workers;
        $array['loc'] = 'Currais Novos';

        return $array;
    }

    public function one($id)
    {
        $array = ['error' => ''];

        $Worker = Worker::find($id);

        if ($Worker) {
            $Worker['avatar'] = url('media/avatars/' . $Worker['avatar']);
            $Worker['favorited'] = false;
            // $Worker['photos'] = [];
            $Worker['services'] = [];
            // $Worker['testimonials'] = [];
            // $Worker['available'] = [];


            // $cFavorite = UserFavorite::where('id_user', $this->loggedUser->id)
            //     ->where('id_Worker', $Worker->id)
            //     ->count();
            // if ($cFavorite > 0) {
            //     $Worker['favorited'] = true;
            // }

            // Pegando as fotos do Barbeiro
            // $Worker['photos'] = WorkerPhotos::select(['id', 'url'])
            //     ->where('id_Worker', $Worker->id)
            //     ->get();
            // foreach ($Worker['photos'] as $bpkey => $bpvalue) {
            //     $Worker['photos'][$bpkey]['url'] = url('media/uploads/' . $Worker['photos'][$bpkey]['url']);
            // }

            // Pegando os serviços do Barbeiro
            $worker['services'] = workerServices::select(['id', 'name', 'price'])
                ->where('id_worker', $worker->id)
                ->get();

            // Pegando os depoimentos do Barbeiro
            // $Worker['testimonials'] = WorkerTestimonial::select(['id', 'name', 'rate', 'body'])
            //     ->where('id_Worker', $Worker->id)
            //     ->get();

            // // Pegando disponibilidade do Barbeiro
            // $availability = [];

            // // - Pegando a disponibilidade crua
            // $avails = WorkerAvailability::where('id_Worker', $Worker->id)->get();
            // $availWeekdays = [];
            // foreach ($avails as $item) {
            //     $availWeekdays[$item['weekday']] = explode(',', $item['hours']);
            // }

            // // - Pegar os agendamentos dos próximos 20 dias
            // $appointments = [];
            // $appQuery = UserAppointment::where('id_Worker', $Worker->id)
            //     ->whereBetween('ap_datetime', [
            //         date('Y-m-d') . ' 00:00:00',
            //         date('Y-m-d', strtotime('+20 days')) . ' 23:59:59'
            //     ])
            //     ->get();
            // foreach ($appQuery as $appItem) {
            //     $appointments[] = $appItem['ap_datetime'];
            // }

            // // - Gerar disponibilidade real
            // for ($q = 0; $q < 20; $q++) {
            //     $timeItem = strtotime('+' . $q . ' days');
            //     $weekday = date('w', $timeItem);

            //     if (in_array($weekday, array_keys($availWeekdays))) {
            //         $hours = [];

            //         $dayItem = date('Y-m-d', $timeItem);

            //         foreach ($availWeekdays[$weekday] as $hourItem) {
            //             $dayFormated = $dayItem . ' ' . $hourItem . ':00';
            //             if (!in_array($dayFormated, $appointments)) {
            //                 $hours[] = $hourItem;
            //             }
            //         }

            //         if (count($hours) > 0) {
            //             $availability[] = [
            //                 'date' => $dayItem,
            //                 'hours' => $hours
            //             ];
            //         }
            //     }
            // }

            // $Worker['available'] = $availability;

            $array['data'] = $Worker;
        } else {
            $array['error'] = 'Barbeiro não existe!';
            return $array;
        }

        return $array;
    }

    // public function setAppointment($id, Request $request)
    // {
    //     // service, year, month, day, hour
    //     $array = ['error' => ''];

    //     $service = $request->input('service');
    //     $year = intval($request->input('year'));
    //     $month = intval($request->input('month'));
    //     $day = intval($request->input('day'));
    //     $hour = intval($request->input('hour'));

    //     $month = ($month < 10) ? '0' . $month : $month;
    //     $day = ($day < 10) ? '0' . $day : $day;
    //     $hour = ($hour < 10) ? '0' . $hour : $hour;

    //     $workerservice = workerServices::select()
    //         ->where('id', $service)
    //         ->where('id_Worker', $id)
    //         ->first();

    //     if ($workerservice) {
    //         $apDate = $year . '-' . $month . '-' . $day . ' ' . $hour . ':00:00';
    //         if (strtotime($apDate) > 0) {

    //             $apps = UserAppointment::select()
    //                 ->where('id_Worker', $id)
    //                 ->where('ap_datetime', $apDate)
    //                 ->count();
    //             if ($apps === 0) {

    //                 $weekday = date('w', strtotime($apDate));
    //                 $avail = WorkerAvailability::select()
    //                     ->where('id_Worker', $id)
    //                     ->where('weekday', $weekday)
    //                     ->first();
    //                 if ($avail) {
    //                     $hours = explode(',', $avail['hours']);
    //                     if (in_array($hour . ':00', $hours)) {

    //                         $newApp = new UserAppointment();
    //                         $newApp->id_user = $this->loggedUser->id;
    //                         $newApp->id_Worker = $id;
    //                         $newApp->id_service = $service;
    //                         $newApp->ap_datetime = $apDate;
    //                         $newApp->save();
    //                     } else {
    //                         $array['error'] = 'Barbeiro não atende nesta hora!';
    //                     }
    //                 } else {
    //                     $array['error'] = 'Barbeiro não atende neste dia!';
    //                 }
    //             } else {
    //                 $array['error'] = 'Barbeiro já possui agendamento neste dia/hora!';
    //             }
    //         } else {
    //             $array['error'] = 'Data inválida!';
    //         }
    //     } else {
    //         $array['error'] = 'Serviço inexistente!';
    //     }

    //     return $array;
    // }

    public function search(Request $request)
    {
        $array = ['error' => '', 'list' => []];

        $q = $request->input('q');

        if ($q) {

            $workers = Worker::select()
                ->where('name', 'LIKE', '%' . $q . '%')
                ->get();

            foreach ($workers as $bkey => $worker) {
                $workers[$bkey]['avatar'] = url('media/avatars/' . $workers[$bkey]['avatar']);
            }

            $array['list'] = $workers;
        } else {
            $array['error'] = 'Digite algo para buscar';
        }

        return $array;
    }
}
