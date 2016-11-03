@if($user)
    <div class="region settings">
        <div class="region-active" style=" margin-top: 15px;">
            <a href="javascript:" data-toggle="dropdown" v-on:click="flow1" style="background-color: inherit">
                <span class="glyphicon glyphicon-cog"> </span>
            </a>

            <div class="dropdown-menu popover" role="menu">
                <div class="settings-board-container">

                    <div class="settings-board">
                        <div class="settings-list">
                            <div class="settings-item link">
                                <a href="http://i.btc.com" class="h-a">{{trans('global.common.users.user-center')}}</a>
                            </div>
                            <div class="settings-item" data-toggle="modal" data-target="#setAddress">
                                <div class="h">
                                    {{trans('global.common.users.BitcoinAddress')}}
                                </div>
                                <div class="b">
                                    <div class="b-inner">
                                        <div class="address"> @{{ userInfo.address  | loading }}</div>
                                    </div>
                                </div>
                                <div class="loading" disabled></div>
                            </div>

                            <div class="settings-item" data-toggle="modal" data-target="#setNMCAddress">
                                <div class="h">
                                    {{trans('global.common.users.NamecoinAddress')}}
                                </div>
                                <div class="b">
                                    <div class="b-inner"  v-cloak>
                                        <div class="address" v-if="userInfo.nmc_address" >  @{{ userInfo.nmc_address  | loading}}</div>
                                        <div class="alert alert-warning" v-else >
                                            <a href="#" class="close" data-dismiss="alert">
                                                &times;
                                            </a>
                                            <strong>* </strong> {{trans('global.common.users.setNMCAddress')}}
                                        </div>
                                    </div>
                                </div>
                                <div class="loading" disabled></div>
                            </div>

                            <div class="settings-item" data-toggle="modal" data-target="#setSubsidyAddress" v-on:click="clear()">
                                <div class="h">
                                    {{trans('global.common.users.subsidy-address')}}
                                </div>
                                <div class="b">
                                    <div class="b-inner" v-cloak>
                                        <div class="address" v-if="userInfo.rebates_address"> @{{ userInfo.rebates_address  | loading}}</div>
                                        <div class="alert alert-warning" v-else>
                                            <a href="#" class="close" data-dismiss="alert">
                                                &times;
                                            </a>
                                            <strong>* </strong> {{trans('global.common.users.setSubsidyAddress')}}。
                                        </div>
                                    </div>
                                </div>
                                <div class="loading" disabled></div>
                            </div>

                            <div class="settings-item link">
                                <a href="{{route('history')}}"
                                   class="h-a">{{trans('global.common.users.EarningsHistory')}}</a>
                            </div>
                            <div class="settings-item link" style="border-bottom: 0;">
                                <a href="{{ \BTCCOM\CAS\logout_url([route('index')]) }}">{{trans('global.common.users.SignOut')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 模态框（Add Group） -->
            <div class="modal fade" id="setAddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <span>{{ trans('global.common.setAddress.ModifyAddress') }}</span>
                        </div>
                        <div class="modal-body">
                            <section v-show="flow==1" class="flow1" tabindex="-1">
                                <a class="v" target="_blank"
                                   href="http://btc.com/@{{userInfo.address}}"> @{{ userInfo.address  }}</a>
                            </section>

                            <section v-show="flow==2" class="flow2">
                                <span class="k">{{ trans('global.common.setAddress.old') }}</span>
                                <a class="v" target="_blank"
                                   href="http://btc.com/@{{userInfo.address}}"> @{{ userInfo.address  }}</a>
                                <span class="k">{{ trans('global.common.setAddress.new') }}</span>
                                <input type="text" class="input-auth" v-model="newAddress"
                                       v-bind:class="error_num==0 ? '' : 'error-line'"
                                       v-bind:key-down="newAddress.trim()=='' ? error_num=-1 : error_num=0"
                                       v-on:keyup.enter="flow3">
                            <span v-show="error_num==-1 && newAddress.trim()==''" class="error-input">
                                {{ trans('global.common.setAddress.emptyAddress') }}
                            </span>
                            <span v-show="error_num==-1 &&  newAddress.trim()!=''" class="error-input">
                                {{ trans('global.common.setAddress.invalidAddress') }}
                            </span>
                            </section>

                            <section v-show="flow==3" class="flow3">
                                <span class="k">{{ trans('global.common.setAddress.newBit') }}</span>
                                <a class="v" target="_blank" href="http://btc.com/@{{newAddress}}">@{{ newAddress }}</a>
                            <span class="k ns">
                                {{ trans('global.common.setAddress.way') }}
                            </span>

                                <label class="checkbox-inline">
                                    <input type="radio" v-model="contact"
                                           value="mail">{{ trans('global.common.setAddress.emailVia') }}
                                    <a>@{{userInfo.contact.mail}}</a>
                                </label>
                                <label class="checkbox-inline">
                                    <input type="radio" v-model="contact"
                                           value="sms">{{ trans('global.common.setAddress.textVia') }}
                                    <a>+@{{userInfo.contact.phone.country  }} @{{userInfo.contact.phone.number}}</a>
                                </label>
                            </section>

                            <section v-show="flow==4" class="flow4">
                                <span class="k">{{ trans('global.common.setAddress.newBit') }}</span>
                                <a class="v" target="_blank" href="http://btc.com/@{{newAddress}}">@{{ newAddress }}</a>
                                {{--邮箱发送--}}
                                <span class="k ns" v-if="contact=='mail'">{{ trans('global.common.setAddress.sendCodeMail') }}</span>
                                {{--短信发送--}}
                                <span class="k ns" v-else>{{ trans('global.common.setAddress.sendCodeMobile') }}</span>

                                <input type="text" class="input-auth" v-model="code"
                                       placeholder="{{ trans('global.common.setAddress.enterCode') }}"
                                       v-bind:class="error_num==0 ? '' : 'error-line'"
                                       v-bind:key-down="code.trim()=='' ? error_num=-1 : error_num=0"
                                       v-on:keyup.enter="flow5">
                            <span v-show="error_num==-1 && code.trim()==''" class="error-input">
                                 {{ trans('global.common.setAddress.emptyCode') }}
                            </span>
                            <span v-show="error_num==-1 && code.trim()!=''" class="error-input error-info">
                                 {{ trans('global.common.setAddress.wrongCode') }}
                            </span>
                            </section>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-primary-small" v-if="flow==1" v-on:click="flow2">
                                {{ trans('global.common.setAddress.Modify') }}
                            </button>
                            <button type="button" class="btn-primary-small" v-if="flow==2" v-on:click="flow3">
                                {{ trans('global.common.setAddress.continue') }}
                            </button>
                            <button type="button" class="btn-primary-small" v-if="flow==3" v-on:click="flow4">
                                {{ trans('global.common.setAddress.continue') }}
                            </button>
                            <button type="button" class="btn-primary-small" v-if="flow==4" v-on:click="flow5">
                                {{ trans('global.common.setAddress.done') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal -->

            <div class="modal fade messageTip" id="successUpdate" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body messageInfo">
                            {{ trans('global.common.setAddress.updateSuccess') }}
                        </div>
                        <div class="modal-footer">
                            <a data-dismiss="modal" aria-hidden="true"> {{ trans('global.common.setAddress.Okay') }}</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade messageTip" id="errorMsg" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body messageInfo">
                            {{ trans('global.common.errorLater') }}
                        </div>
                        <div class="modal-footer">
                            <a data-dismiss="modal" aria-hidden="true"> {{ trans('global.common.setAddress.Okay') }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 模态框（Add Group） -->
            <div class="modal fade" id="setNMCAddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  v-on:click="clear()">×</button>
                            <span>{{ trans('global.common.setAddress.ModifyAddress') }}</span>
                        </div>
                        <div class="modal-body">
                            <section>
                                <span class="k">{{ trans('global.common.setAddress.new') }}</span>
                                <input type="text" class="input-auth" v-model="nmc_new_address"
                                       v-bind:class="nmc_error_num==0 ? '' : 'error-line'">
                                <span v-show="nmc_error_num==-1" class="error-input nmc-error-info">
                                    {{ trans('global.common.setAddress.emptyAddress') }}
                                </span>
                            </section>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-primary-small" v-on:click="updateNMCAddress">
                                {{ trans('global.common.setAddress.Modify') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal -->

            <!-- 模态框（Add Group） -->
            <div class="modal fade" id="setSubsidyAddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  v-on:click="clear()">×</button>
                            <span>{{ trans('global.common.setAddress.ModifyAddress') }}</span>
                        </div>
                        <div class="modal-body">
                            <section>
                                <span class="k">{{ trans('global.common.setAddress.new') }}</span>
                                <input type="text" class="input-auth" v-model="subsidy_new_address"
                                       v-bind:class="subsidy_error_num==0 ? '' : 'error-line'">
                                <span v-show="subsidy_error_num==-1" class="error-input subsidy-error-info">
                                    {{ trans('global.common.setAddress.emptyAddress') }}
                                </span>
                            </section>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-primary-small" v-on:click="updateSubsidyAddress()">
                                {{ trans('global.common.setAddress.Modify') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal -->

        </div>
    </div>
@endif

@push('footer_script')
<script>
    const $ = require('jquery');
    require('bootstrap');
    const accessKey = window.__btccom.ak;
    if (accessKey != 0) {
        require('/modules/address');
    }
</script>
@endpush