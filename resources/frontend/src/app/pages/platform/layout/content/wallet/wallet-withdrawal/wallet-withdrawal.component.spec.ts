import { ComponentFixture, TestBed } from '@angular/core/testing';

import { WalletWithdrawalComponent } from './wallet-withdrawal.component';

describe('WalletWithdrawalComponent', () => {
  let component: WalletWithdrawalComponent;
  let fixture: ComponentFixture<WalletWithdrawalComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ WalletWithdrawalComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(WalletWithdrawalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
