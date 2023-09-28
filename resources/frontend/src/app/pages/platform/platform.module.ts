import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {LayoutComponent} from './layout/layout.component';
import {RoleComponent} from './layout/content/system/role/role.component';
import {ManagerComponent} from './layout/content/system/manager/manager.component';
import {ActionLogComponent} from './layout/content/system/action-log/action-log.component';
import {NavigationComponent} from './layout/content/system/navigation/navigation.component';
import {DashboardComponent} from './layout/content/system/dashboard/dashboard.component';
import {NzModalModule, NzModalService} from "ng-zorro-antd/modal";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzLayoutModule} from "ng-zorro-antd/layout";
import {NzMenuModule} from "ng-zorro-antd/menu";
import {NzIconModule} from "ng-zorro-antd/icon";
import {RouterLinkActive, RouterOutlet} from "@angular/router";
import {PlatformRoutingModule} from "./platform-routing.module";
import {NzTableModule} from "ng-zorro-antd/table";
import {NzDividerModule} from "ng-zorro-antd/divider";
import {NzFormModule} from "ng-zorro-antd/form";
import {ReactiveFormsModule} from "@angular/forms";
import {NzTransferModule} from "ng-zorro-antd/transfer";
import {NzButtonModule} from "ng-zorro-antd/button";
import {DragDropModule} from "@angular/cdk/drag-drop";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzSelectModule} from "ng-zorro-antd/select";
import {AgreementComponent} from "./layout/content/system/agreement/agreement.component";
import {ComplaintComponent} from "./layout/content/system/complaint/complaint.component";
import {SystemConfigComponent} from "./layout/content/system/system-config/system-config.component";
import { ImageComponent } from './layout/content/system/image/image.component';
import { TargetComponent } from './layout/content/system/target/target.component';
import { UnitComponent } from './layout/content/system/unit/unit.component';
import { AppBugLogComponent } from './layout/content/system/app-bug-log/app-bug-log.component';
import { AppPublishLogComponent } from './layout/content/system/app-publish-log/app-publish-log.component';
import { GameComponent } from './layout/content/competition/game/game.component';
import { RoomComponent } from './layout/content/competition/room/room.component';
import { GameTeamComponent } from './layout/content/competition/game-team/game-team.component';
import { OrdersComponent } from './layout/content/order/orders/orders.component';
import { OrderIncomeComponent } from './layout/content/order/order-income/order-income.component';
import { OrderIncomeConfigComponent } from './layout/content/order/order-income-config/order-income-config.component';
import { QuestComponent } from './layout/content/activity/quest/quest.component';
import { LuckyDrawsItemComponent } from './layout/content/activity/lucky-draws-item/lucky-draws-item.component';
import { LuckyDrawsConfigComponent } from './layout/content/activity/lucky-draws-config/lucky-draws-config.component';
import { GoodsComponent } from './layout/content/goods/goods/goods.component';
import { ProductVipComponent } from './layout/content/goods/product-vip/product-vip.component';
import { ProductRechargeComponent } from './layout/content/goods/product-recharge/product-recharge.component';
import { WalletsComponent } from './layout/content/wallet/wallets/wallets.component';
import { WalletRechargeComponent } from './layout/content/wallet/wallet-recharge/wallet-recharge.component';
import { WalletWithdrawalComponent } from './layout/content/wallet/wallet-withdrawal/wallet-withdrawal.component';
import { WalletWithdrawalAccountComponent } from './layout/content/wallet/wallet-withdrawal-account/wallet-withdrawal-account.component';
import { WalletConsumeComponent } from './layout/content/wallet/wallet-consume/wallet-consume.component';
import { WalletLogComponent } from './layout/content/wallet/wallet-log/wallet-log.component';
import { MembersComponent } from './layout/content/member/members/members.component';
import { MemberAddressComponent } from './layout/content/member/member-address/member-address.component';
import { MemberBanLogComponent } from './layout/content/member/member-ban-log/member-ban-log.component';
import { MemberMessageComponent } from './layout/content/member/member-message/member-message.component';
import { TitleComponent } from './layout/content/member/title/title.component';
import { WechatMiniProgramAccountComponent } from './layout/content/wechat/wechat-mini-program-account/wechat-mini-program-account.component';
import { WechatOfficeAccountComponent } from './layout/content/wechat/wechat-office-account/wechat-office-account.component';
import {NzInputNumberModule} from "ng-zorro-antd/input-number";
import {NzSwitchModule} from "ng-zorro-antd/switch";
import {NzRadioModule} from "ng-zorro-antd/radio";
import {NzDatePickerModule} from "ng-zorro-antd/date-picker";


@NgModule({
    declarations: [
        LayoutComponent,
        RoleComponent,
        ManagerComponent,
        ActionLogComponent,
        NavigationComponent,
        DashboardComponent,
        AgreementComponent,
        ComplaintComponent,
        SystemConfigComponent,
        ImageComponent,
        TargetComponent,
        UnitComponent,
        AppBugLogComponent,
        AppPublishLogComponent,
        GameComponent,
        RoomComponent,
        GameTeamComponent,
        OrdersComponent,
        OrderIncomeComponent,
        OrderIncomeConfigComponent,
        QuestComponent,
        LuckyDrawsItemComponent,
        LuckyDrawsConfigComponent,
        GoodsComponent,
        ProductVipComponent,
        ProductRechargeComponent,
        WalletsComponent,
        WalletRechargeComponent,
        WalletWithdrawalComponent,
        WalletWithdrawalAccountComponent,
        WalletConsumeComponent,
        WalletLogComponent,
        MembersComponent,
        MemberAddressComponent,
        MemberBanLogComponent,
        MemberMessageComponent,
        TitleComponent,
        WechatMiniProgramAccountComponent,
        WechatOfficeAccountComponent,
    ],
  imports: [
    CommonModule,
    PlatformRoutingModule,
    NzLayoutModule,
    NzMenuModule,
    NzIconModule,
    RouterOutlet,
    RouterLinkActive,
    NzTableModule,
    NzDividerModule,
    NzModalModule,
    NzFormModule,
    ReactiveFormsModule,
    NzTransferModule,
    NzButtonModule,
    DragDropModule,
    NzInputModule,
    NzSelectModule,
    NzInputNumberModule,
    NzSwitchModule,
    NzRadioModule,
    NzDatePickerModule,
  ],
    providers: [NzModalService, NzMessageService]
})
export class PlatformModule {
}
