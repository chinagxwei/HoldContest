import { ComponentFixture, TestBed } from '@angular/core/testing';

import { WalletConsumeComponent } from './wallet-consume.component';

describe('WalletConsumeComponent', () => {
  let component: WalletConsumeComponent;
  let fixture: ComponentFixture<WalletConsumeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ WalletConsumeComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(WalletConsumeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
