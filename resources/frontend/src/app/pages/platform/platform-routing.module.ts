import {RouterModule, Routes} from '@angular/router';
import {NgModule} from '@angular/core';
import {LayoutComponent} from "./layout/layout.component";
import {AdminGuard} from "../../guard/admin.guard";
import {DashboardComponent} from "./layout/content/system/dashboard/dashboard.component";
import {RoleComponent} from "./layout/content/system/role/role.component";
import {ActionLogComponent} from "./layout/content/system/action-log/action-log.component";
import {NavigationComponent} from "./layout/content/system/navigation/navigation.component";
import {ManagerComponent} from "./layout/content/system/manager/manager.component";
import {AgreementComponent} from "./layout/content/system/agreement/agreement.component";
import {ComplaintComponent} from "./layout/content/system/complaint/complaint.component";
import {SystemConfigComponent} from "./layout/content/system/system-config/system-config.component";
import {ImageComponent} from "./layout/content/system/image/image.component";
import {TargetComponent} from "./layout/content/system/target/target.component";
import {UnitComponent} from "./layout/content/system/unit/unit.component";
import {AppBugLogComponent} from "./layout/content/system/app-bug-log/app-bug-log.component";
import {AppPublishLogComponent} from "./layout/content/system/app-publish-log/app-publish-log.component";
import {GameComponent} from "./layout/content/competition/game/game.component";
import {RoomComponent} from "./layout/content/competition/room/room.component";
import {GameTeamComponent} from "./layout/content/competition/game-team/game-team.component";
import {OrdersComponent} from "./layout/content/order/orders/orders.component";
import {OrderIncomeComponent} from "./layout/content/order/order-income/order-income.component";
import {OrderIncomeConfigComponent} from "./layout/content/order/order-income-config/order-income-config.component";
import {QuestComponent} from "./layout/content/activity/quest/quest.component";
import {LuckyDrawsItemComponent} from "./layout/content/activity/lucky-draws-item/lucky-draws-item.component";
import {LuckyDrawsConfigComponent} from "./layout/content/activity/lucky-draws-config/lucky-draws-config.component";
import {GoodsComponent} from "./layout/content/goods/goods/goods.component";
import {ProductVipComponent} from "./layout/content/goods/product-vip/product-vip.component";
import {ProductRechargeComponent} from "./layout/content/goods/product-recharge/product-recharge.component";
import {WalletsComponent} from "./layout/content/wallet/wallets/wallets.component";
import {WalletRechargeComponent} from "./layout/content/wallet/wallet-recharge/wallet-recharge.component";
import {WalletWithdrawalComponent} from "./layout/content/wallet/wallet-withdrawal/wallet-withdrawal.component";
import {
  WalletWithdrawalAccountComponent
} from "./layout/content/wallet/wallet-withdrawal-account/wallet-withdrawal-account.component";
import {WalletConsumeComponent} from "./layout/content/wallet/wallet-consume/wallet-consume.component";
import {WalletLogComponent} from "./layout/content/wallet/wallet-log/wallet-log.component";
import {TitleComponent} from "./layout/content/member/title/title.component";
import {MembersComponent} from "./layout/content/member/members/members.component";
import {MemberAddressComponent} from "./layout/content/member/member-address/member-address.component";
import {MemberBanLogComponent} from "./layout/content/member/member-ban-log/member-ban-log.component";
import {MemberMessageComponent} from "./layout/content/member/member-message/member-message.component";

const platformRoutes: Routes = [
  {
    path: '',
    component: LayoutComponent,
    canActivate: [AdminGuard],
    children: [
      {
        path: '',
        canActivateChild: [AdminGuard],
        children: [
          {path: '', component: DashboardComponent},
          {path: 'system/agreement', component: AgreementComponent},
          {path: 'system/complaint', component: ComplaintComponent},
          {path: 'system/images', component: ImageComponent},
          {path: 'system/target', component: TargetComponent},
          {path: 'system/unit', component: UnitComponent},
          {path: 'system/system-config', component: SystemConfigComponent},
          {path: 'system/navigation', component: NavigationComponent},
          {path: 'system/role', component: RoleComponent},
          {path: 'system/manager', component: ManagerComponent},
          {path: 'system/action-log', component: ActionLogComponent},
          {path: 'system/app-bug-log', component: AppBugLogComponent},
          {path: 'system/app-publish-log', component: AppPublishLogComponent},
          {path: 'system/competition-game', component: GameComponent},
          {path: 'system/competition-room', component: RoomComponent},
          {path: 'system/competition-game-team', component: GameTeamComponent},
          {path: 'system/order', component: OrdersComponent},
          {path: 'system/order-income', component: OrderIncomeComponent},
          {path: 'system/order-income-config', component: OrderIncomeConfigComponent},
          {path: 'system/quest', component: QuestComponent},
          {path: 'system/lucky-draws-item', component: LuckyDrawsItemComponent},
          {path: 'system/lucky-draws-config', component: LuckyDrawsConfigComponent},
          {path: 'system/goods', component: GoodsComponent},
          {path: 'system/product-recharge', component: ProductRechargeComponent},
          {path: 'system/product-vip', component: ProductVipComponent},
          {path: 'system/wallet', component: WalletsComponent},
          {path: 'system/wallet-recharge', component: WalletRechargeComponent},
          {path: 'system/wallet-withdrawal', component: WalletWithdrawalComponent},
          {path: 'system/wallet-withdrawal-account', component: WalletWithdrawalAccountComponent},
          {path: 'system/wallet-consume', component: WalletConsumeComponent},
          {path: 'system/wallet-log', component: WalletLogComponent},
          {path: 'system/title', component: TitleComponent},
          {path: 'system/member', component: MembersComponent},
          {path: 'system/member-address', component: MemberAddressComponent},
          {path: 'system/member-ban-log', component: MemberBanLogComponent},
          {path: 'system/member-message', component: MemberMessageComponent},
        ]
      }
    ]
  }
];

@NgModule({
  imports: [
    RouterModule.forChild(platformRoutes)
  ],
  exports: [
    RouterModule
  ]
})
export class PlatformRoutingModule {
}
