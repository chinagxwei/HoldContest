import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MemberAddressComponent } from './member-address.component';

describe('MemberAddressComponent', () => {
  let component: MemberAddressComponent;
  let fixture: ComponentFixture<MemberAddressComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MemberAddressComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MemberAddressComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
