import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SetMemberVipComponent } from './set-member-vip.component';

describe('SetMemberVipComponent', () => {
  let component: SetMemberVipComponent;
  let fixture: ComponentFixture<SetMemberVipComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SetMemberVipComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SetMemberVipComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
