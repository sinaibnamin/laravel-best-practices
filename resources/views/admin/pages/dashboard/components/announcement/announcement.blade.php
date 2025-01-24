
                    @if ($announcement->type == 'info')
                        <div class="alert alert-info alert-dismissible">
                            <h5><i class="icon fas fa-info"></i> {{$announcement->headline}}</h5>
                            {{$announcement->description}}
                        </div>
                    @endif
                    @if ($announcement->type == 'danger')
                        <div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> {{$announcement->headline}}</h5>
                            {{$announcement->description}}
                        </div>
                    @endif
                    @if ($announcement->type == 'warning')
                        <div class="alert alert-warning alert-dismissible">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> {{$announcement->headline}}</h5>
                            {{$announcement->description}}
                        </div>
                    @endif
                    @if ($announcement->type == 'success')
                        <div class="alert alert-success alert-dismissible">
                            <h5><i class="icon fas fa-check"></i> {{$announcement->headline}}</h5>
                            {{$announcement->description}}
                        </div>
                    @endif
             