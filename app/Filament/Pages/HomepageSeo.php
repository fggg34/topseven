<?php

namespace App\Filament\Pages;

use App\Filament\RestrictedPanelUser;
use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\URL;

/**
 * SEO for the public homepage (/). Settings keys: homepage_seo_*.
 *
 * @property-read Schema $form
 */
class HomepageSeo extends Page
{
    /** @var array<string, mixed> */
    public array $form = [];

    protected static ?string $slug = 'homepage/seo';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static ?string $navigationLabel = 'Homepage SEO';

    protected static ?string $navigationParentItem = 'Homepage';

    protected static ?string $title = 'Homepage SEO';

    protected static string|\UnitEnum|null $navigationGroup = 'Pages';

    protected static ?int $navigationSort = 55;

    protected string $view = 'filament.pages.settings';

    public static function canAccess(): bool
    {
        if (RestrictedPanelUser::isCurrentUser()) {
            return false;
        }

        return parent::canAccess();
    }

    public function mount(): void
    {
        abort_unless(static::canAccess(), 403);

        $this->getSchema('form')->fill([
            'homepage_seo_title' => Setting::get('homepage_seo_title', ''),
            'homepage_seo_description' => Setting::get('homepage_seo_description', ''),
            'homepage_seo_og_image' => Setting::get('homepage_seo_og_image', ''),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('form')
            ->components([
                Section::make('SEO')
                    ->description('Meta tags and social preview for '.URL::to('/').'. Leave fields empty to use the site defaults (name, tagline, hero subtitle, default OG image from Site Settings).')
                    ->schema([
                        TextInput::make('homepage_seo_title')
                            ->label('Meta title')
                            ->maxLength(255)
                            ->helperText('When empty, the homepage uses “Site name — tagline” from Site Settings.')
                            ->columnSpanFull(),
                        Textarea::make('homepage_seo_description')
                            ->label('Meta description')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('When empty, the homepage uses the legacy hero subtitle setting if set.')
                            ->columnSpanFull(),
                        FileUpload::make('homepage_seo_og_image')
                            ->label('Open Graph image')
                            ->image()
                            ->disk('public')
                            ->directory('pages/home')
                            ->visibility('public')
                            ->imagePreviewHeight('120')
                            ->maxSize(4096)
                            ->helperText('Recommended 1200×630px. When empty, the default OG image from Site Settings is used.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Save homepage SEO')
                                ->submit('save'),
                        ])->alignment(\Filament\Support\Enums\Alignment::Start),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->getSchema('form')->getState();

        Setting::set('homepage_seo_title', (string) ($data['homepage_seo_title'] ?? ''));
        Setting::set('homepage_seo_description', (string) ($data['homepage_seo_description'] ?? ''));
        Setting::set('homepage_seo_og_image', $this->normalizeUpload($data['homepage_seo_og_image'] ?? ''));

        Notification::make()
            ->title('Homepage SEO saved.')
            ->success()
            ->send();
    }

    private function normalizeUpload(mixed $value): string
    {
        if (is_array($value)) {
            return (string) ($value[0] ?? '');
        }

        return $value ? (string) $value : '';
    }
}
