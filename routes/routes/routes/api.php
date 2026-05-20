use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User; // Ili tvoj Player model

Route::get('/leaderboard', function () {
    // Primjer: vrati top 50 igrača po XP-u
    $leaders = User::orderBy('xp', 'desc')
        ->take(50)
        ->get(['id', 'username', 'avatar', 'xp', 'level'])
        ->map(function($user, $index) {
            return [
                'rank' => $index + 1,
                'username' => $user->username,
                'avatar' => $user->avatar,
                'xp' => $user->xp ?? 0,
                'level' => $user->level ?? 1,
                'trend' => $index < 3 ? 'up' : 'down' // Primjer trenda
            ];
        });
    
    return response()->json($leaders);
})->middleware('auth:api'); // Ako koristiš API auth
