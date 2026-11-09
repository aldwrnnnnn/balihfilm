<?php

/**
 * Balih Film - Modern Cinema Booking System
 *
 * @author    I Gede Aldi Irawan <gedealdiirawan5@gmail.com>
 * @copyright 2026 I Gede Aldi Irawan (https://github.com/aldwrnnnnn)
 * @license   All Rights Reserved / Proprietary
 */

namespace App\Http\Controllers;

use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieController extends Controller
{
    /**
     * Display a listing of movies (now playing & upcoming).
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $genre = $request->query('genre');
        $search = $request->query('q');

        $query = Movie::query();

        if ($status === 'now_playing' || $status === 'upcoming') {
            $query->where('status', $status);
        }

        if ($genre) {
            $query->where('genre', 'like', "%{$genre}%");
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('director', 'like', "%{$search}%")
                    ->orWhere('cast', 'like', "%{$search}%");
            });
        }

        $movies = $query->orderBy('release_date', 'desc')->get();

        $nowPlaying = Movie::where('status', 'now_playing')
            ->with(['showtimes' => function ($q) {
                $q->where('show_date', '>=', Carbon::today())
                    ->orderBy('show_date')
                    ->orderBy('start_time');
            }])
            ->get();

        $upcoming = Movie::where('status', 'upcoming')
            ->orderBy('release_date', 'asc')
            ->get();

        return view('movies.index', [
            'movies' => $movies,
            'nowPlaying' => $nowPlaying,
            'upcoming' => $upcoming,
            'currentStatus' => $status,
            'currentGenre' => $genre,
            'searchQuery' => $search,
        ]);
    }

    /**
     * Display the specified movie details and its showtimes.
     */
    public function show(string $slug): View
    {
        $movie = Movie::where('slug', $slug)
            ->with(['showtimes' => function ($q) {
                $q->where('show_date', '>=', Carbon::today())
                    ->with('studio')
                    ->orderBy('show_date')
                    ->orderBy('start_time');
            }])
            ->firstOrFail();

        // Group showtimes by show_date formatted
        $groupedShowtimes = $movie->showtimes->groupBy(function ($showtime) {
            return Carbon::parse($showtime->show_date)->translatedFormat('l, d M Y');
        });

        // Also get other now playing movies for recommendation
        $recommended = Movie::where('id', '!=', $movie->id)
            ->where('status', 'now_playing')
            ->take(4)
            ->get();

        return view('movies.show', [
            'movie' => $movie,
            'groupedShowtimes' => $groupedShowtimes,
            'recommended' => $recommended,
        ]);
    }
}
