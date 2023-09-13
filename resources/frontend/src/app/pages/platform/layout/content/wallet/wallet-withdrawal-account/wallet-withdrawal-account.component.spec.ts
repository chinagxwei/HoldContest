import { ComponentFixture, TestBed } from '@angular/core/testing';

import { WalletWithdrawalAccountComponent } from './wallet-withdrawal-account.component';

describe('WalletWithdrawalAccountComponent', () => {
  let component: WalletWithdrawalAccountComponent;
  let fixture: ComponentFixture<WalletWithdrawalAccountComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ WalletWithdrawalAccountComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(WalletWithdrawalAccountComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
