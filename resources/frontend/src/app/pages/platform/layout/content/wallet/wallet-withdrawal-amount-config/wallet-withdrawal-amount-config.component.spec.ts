import { ComponentFixture, TestBed } from '@angular/core/testing';

import { WalletWithdrawalAmountConfigComponent } from './wallet-withdrawal-amount-config.component';

describe('WalletWithdrawalAmountConfigComponent', () => {
  let component: WalletWithdrawalAmountConfigComponent;
  let fixture: ComponentFixture<WalletWithdrawalAmountConfigComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ WalletWithdrawalAmountConfigComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(WalletWithdrawalAmountConfigComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
