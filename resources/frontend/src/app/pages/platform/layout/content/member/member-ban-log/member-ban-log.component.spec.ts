import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MemberBanLogComponent } from './member-ban-log.component';

describe('MemberBanLogComponent', () => {
  let component: MemberBanLogComponent;
  let fixture: ComponentFixture<MemberBanLogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MemberBanLogComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MemberBanLogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
