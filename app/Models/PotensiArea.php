<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PotensiArea extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'potensi_areas';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nama',
        'kategori',
        'deskripsi',
        'latitude',
        'longitude',
        'foto',
        'user_id',
        'is_approved',
        'alasan_penolakan',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejected_by'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'deleted_at'
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto set user_id when creating
        static::creating(function ($model) {
            if (auth()->check() && !$model->user_id) {
                $model->user_id = auth()->id();
            }
        });
    }

    /**
     * Get the user that owns the potensi area.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who approved this potensi area.
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the user who rejected this potensi area.
     */
    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    /**
     * Scope for pending approval.
     */
    public function scopePending($query)
    {
        return $query->whereNull('is_approved');
    }

    /**
     * Scope for approved items.
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope for rejected items.
     */
    public function scopeRejected($query)
    {
        return $query->where('is_approved', false);
    }

    /**
     * Scope for searching by name.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('nama', 'like', '%' . $term . '%')
                    ->orWhere('deskripsi', 'like', '%' . $term . '%');
    }

    /**
     * Scope for filtering by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('kategori', 'like', '%' . $category . '%');
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute()
    {
        if (is_null($this->is_approved)) {
            return 'Menunggu Verifikasi';
        }
        
        return $this->is_approved ? 'Disetujui' : 'Ditolak';
    }

    /**
     * Get status color class.
     */
    public function getStatusColorAttribute()
    {
        if (is_null($this->is_approved)) {
            return 'bg-yellow-100 text-yellow-800';
        }
        
        return $this->is_approved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    }

    /**
     * Get category color class.
     */
    public function getCategoryColorAttribute()
    {
        $category = strtolower($this->kategori);
        
        if (stripos($category, 'wisata') !== false) {
            return 'bg-blue-100 text-blue-800';
        } elseif (stripos($category, 'peternakan') !== false) {
            return 'bg-green-100 text-green-800';
        } elseif (stripos($category, 'pertanian') !== false) {
            return 'bg-yellow-100 text-yellow-800';
        } elseif (stripos($category, 'kuliner') !== false) {
            return 'bg-purple-100 text-purple-800';
        }
        
        return 'bg-gray-100 text-gray-800';
    }

    /**
     * Get full photo URL.
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->foto && $this->foto !== 'null') {
            return asset('storage/' . $this->foto);
        }
        
        return null;
    }

    /**
     * Check if has photo.
     */
    public function hasPhoto()
    {
        return $this->foto && $this->foto !== 'null';
    }

    /**
     * Get formatted coordinates.
     */
    public function getFormattedCoordinatesAttribute()
    {
        return [
            'latitude' => number_format($this->latitude, 6),
            'longitude' => number_format($this->longitude, 6)
        ];
    }
}