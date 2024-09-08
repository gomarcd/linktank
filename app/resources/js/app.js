import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from '@ryangjchandler/alpine-clipboard'
import './bootstrap';
import '../../vendor/masmerise/livewire-toaster/resources/js';
 
Alpine.plugin(Clipboard)
window.Alpine = Alpine
window.Alpine.start()
Livewire.start()