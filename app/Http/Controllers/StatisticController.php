<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Models\Customer;
use App\Models\Ticket;
use App\Models\Screening;
class StatisticController extends Controller
{
    public function index(): View
    {
        $salesByMonth = Ticket::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as tickets_sold, ROUND(SUM(price),0) as total_sales")
            ->groupBy('month')
            ->orderBy('total_sales', 'desc')
            ->take(5)
            ->get();

        $salesByMovie = Ticket::join('screenings', 'tickets.screening_id', '=', 'screenings.id')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->selectRaw('movies.title, COUNT(tickets.id) as tickets_sold')
            ->groupBy('movies.title')
            ->orderBy('tickets_sold', 'desc')
            ->take(5)
            ->get();

        $occupancyByMovie = Screening::query()
            ->join('tickets', 'screenings.id', '=', 'tickets.screening_id')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->selectRaw('movies.title, ROUND((COUNT(tickets.id) / (SELECT COUNT(*) FROM seats WHERE seats.theater_id = screenings.theater_id)),0) as occupancy_rate')
            ->groupBy('movies.title', 'screenings.theater_id')
            ->orderBy('occupancy_rate', 'desc')
            ->limit(5)
            ->get();

        $customerPurchases = Customer::join('purchases', 'customers.id', '=', 'purchases.customer_id')
            ->join('users', 'users.id', '=', 'customers.id')
            ->selectRaw('users.name, COUNT(purchases.id) as purchases, ROUND(SUM(purchases.total_price),0) as total_spent')
            ->groupBy('users.name')
            ->orderBy('total_spent', 'desc')
            ->take(5)
            ->get();


        return view('statistics.index', compact('salesByMonth', 'salesByMovie', 'occupancyByMovie', 'customerPurchases'));
    }

}
