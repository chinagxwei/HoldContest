import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AppPublishLogComponent } from './app-publish-log.component';

describe('AppPublishLogComponent', () => {
  let component: AppPublishLogComponent;
  let fixture: ComponentFixture<AppPublishLogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AppPublishLogComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AppPublishLogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
