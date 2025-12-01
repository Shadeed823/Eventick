<?php

use App\Models\Policy;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

function isNavbarActive(string $url): string
{
    return Request()->is($url) ? 'active' : '';
}
function isNavbarTreeActive(string $url): string
{
    return Request()->is(app()->getLocale().'/'.$url) ? 'is-expanded' : '';
}
function isFullUrl(string $url): string
{
    return Request()->fullUrl() == url(app()->getLocale().'/'.$url) ? 'active' : '';
}
function getAuthByGuard(string $guard): Authenticatable
{
    return auth()->guard($guard)->user();
}
function hasRole($roleName): bool
{
    $user = Auth::user();
    if ($user->id == 1 && $roleName != 'normal') {
        return true;
    }
    // Ensure user is authenticated and has a role
    if ($user && $user->role) {
        return $user->role->name === $roleName;
    }

    return false;
}
function hasPermission($permissionName)
{
    $user = Auth::user();
    if ($user->id == 1) {
        return true;
    }

    // Ensure user is authenticated and has permissions through their role
    if ($user && $user->role) {
        return $user->role->permissions()->where('perm_name', $permissionName)->exists();
    }

    return false;
}

 function getTodayPolicies()
{
    return Policy::where('type', 'policy')
        ->whereDate('created_at', Carbon::today())
        ->get();
}
 function getTodayStandards()
{
   return Policy::where('type', 'standard')
        ->whereDate('created_at', Carbon::today())
        ->get();
}
if (!function_exists('getNotificationIcon')) {
    function getNotificationIcon($type)
    {
        switch ($type) {
            case 'تحديث الحفظ': return 'fa-book-open';
            case 'إشعار جديد': return 'fa-envelope';
            case 'تنبيه مهم': return 'fa-exclamation-circle';
            case 'تقدم الحفظ': return 'fa-chart-line';
            default: return 'fa-info-circle';
        }
    }
}
if (!function_exists('getQuranSurahs')) {
    function getQuranSurahs()
    {
        return [
            "الفاتحة", "البقرة", "آل عمران", "النساء", "المائدة", "الأنعام", "الأعراف", "الأنفال", "التوبة",
            "يونس", "هود", "يوسف", "الرعد", "إبراهيم", "الحجر", "النحل", "الإسراء", "الكهف", "مريم", "طه",
            "الأنبياء", "الحج", "المؤمنون", "النور", "الفرقان", "الشعراء", "النمل", "القصص", "العنكبوت",
            "الروم", "لقمان", "السجدة", "الأحزاب", "سبأ", "فاطر", "يس", "الصافات", "ص", "الزمر", "غافر",
            "فصلت", "الشورى", "الزخرف", "الدخان", "الجاثية", "الأحقاف", "محمد", "الفتح", "الحجرات", "ق",
            "الذاريات", "الطور", "النجم", "القمر", "الرحمن", "الواقعة", "الحديد", "المجادلة", "الحشر",
            "الممتحنة", "الصف", "الجمعة", "المنافقون", "التغابن", "الطلاق", "التحريم", "الملك", "القلم",
            "الحاقة", "المعارج", "نوح", "الجن", "المزمل", "المدثر", "القيامة", "الإنسان", "المرسلات",
            "النبأ", "النازعات", "عبس", "التكوير", "الإنفطار", "المطففين", "الإنشقاق", "البروج",
            "الطارق", "الأعلى", "الغاشية", "الفجر", "البلد", "الشمس", "الليل", "الضحى", "الشرح",
            "التين", "العلق", "القدر", "البينة", "الزلزلة", "العاديات", "القارعة", "التكاثر",
            "العصر", "الهمزة", "الفيل", "قريش", "الماعون", "الكوثر", "الكافرون", "النصر",
            "المسد", "الإخلاص", "الفلق", "الناس"
        ];
    }
}

function getFileIconClass($filePath) {
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    switch (strtolower($extension)) {
        case 'pdf':
            return 'fas fa-file-pdf';
        case 'doc':
        case 'docx':
            return 'fas fa-file-word';
        case 'xls':
        case 'xlsx':
            return 'fas fa-file-excel';
        case 'ppt':
        case 'pptx':
            return 'fas fa-file-powerpoint';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            return 'fas fa-file-image';
        case 'zip':
        case 'rar':
        case '7z':
            return 'fas fa-file-archive';
        case 'txt':
            return 'fas fa-file-alt';
        case 'csv':
            return 'fas fa-file-csv';
        default:
            return 'fas fa-file';
    }
}

function isActive($routeName) {
    return request()->routeIs($routeName) ? 'active' : '';
}
