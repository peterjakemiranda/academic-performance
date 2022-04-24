<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use HasFactory, SoftDeletes;

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('school_year', 'like', '%'.$search.'%')
                    ->orWhere('semester', 'like', '%'.$search.'%');
            })
            ->orWhereHas('student',function ($query) use ($search) {
                $query->where('number', 'like', '%'.$search.'%')
                    ->orWhere('name', 'like', '%'.$search.'%');
            });
        })->when($filters['student'] ?? null, function ($query, $student) {
            $query->where('student_id', '=', $student);
        })->when($filters['school_year'] ?? null, function ($query, $schoolYear) {
            $query->where('school_year', '=', $schoolYear);
        })->when($filters['semester'] ?? null, function ($query, $semester) {
            $query->where('semester', '=', $semester);
        });
    }
    
    public function scopeOrderByYear($query)
    {
        $query->orderBy('school_year');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public static function schoolYears()
    {
        $schoolYears = [];
        for ($i=2018; $i < now()->addYear()->format('Y'); $i++) { 
            $schoolYears[] = $i.'-'.($i+1);
        }
        return $schoolYears;
    }

    public static function semesters()
    {
        return ['1','2','S'];
    }
}
